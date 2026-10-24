<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Invoice;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class InvoiceNumberService
{
    /**
     * Maximum attempts for a single generate() call, including the first
     * attempt. Kept small and bounded: a retry only helps when another
     * process committed a conflicting number in between, which the
     * row lock below already makes rare. After this many attempts the
     * original exception is rethrown so a real problem is never hidden.
     */
    private const MAX_ATTEMPTS = 5;

    public function generate(Business $business, string $type = 'invoice'): string
    {
        $attempt = 0;

        while (true) {
            $attempt++;

            try {
                // The whole read-check-update sequence runs inside one
                // transaction, and the business row is re-read fresh with
                // a pessimistic write lock. Concurrent generate() calls
                // for the SAME business therefore serialize: the second
                // caller blocks until the first transaction commits, then
                // reads the already-advanced counter instead of the stale
                // value the caller originally loaded. Calls for different
                // businesses lock different rows and do not block each
                // other.
                $result = DB::transaction(function () use ($business, $type) {
                    $locked = Business::where('id', $business->id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    if ($type === 'estimate') {
                        $prefix = $locked->estimate_number_prefix ?? 'EST';
                        $next = $locked->estimate_number_next ?? 1;
                        $updateField = 'estimate_number_next';
                    } else {
                        $prefix = $locked->invoice_number_prefix ?? 'INV';
                        $next = $locked->invoice_number_next ?? 1;
                        $updateField = 'invoice_number_next';
                    }

                    $unique = false;
                    $number = '';

                    while (!$unique) {
                        $number = sprintf('%s-%04d', $prefix, $next);

                        // Check if this number already exists for this business
                        $exists = Invoice::where('business_id', $locked->id)
                            ->where('invoice_number', $number)
                            ->exists();

                        if (!$exists) {
                            $unique = true;
                        } else {
                            $next++;
                        }
                    }

                    // Update the business's next number for future use
                    $locked->update([$updateField => $next + 1]);

                    return [
                        'number' => $number,
                        'updateField' => $updateField,
                        'nextValue' => $next + 1,
                    ];
                });

                // Keep the caller's in-memory model in sync, exactly as
                // the previous implementation did via $business->update().
                // This only happens after the transaction has committed.
                $business->{$result['updateField']} = $result['nextValue'];

                return $result['number'];
            } catch (QueryException $e) {
                if ($attempt >= self::MAX_ATTEMPTS || !$this->isRetryable($e)) {
                    throw $e;
                }

                // Residual race (e.g. a number created outside this
                // service between the check and the caller's insert, or a
                // lock-wait/deadlock under heavy concurrency): retry the
                // whole transaction so the next attempt re-reads the
                // freshly locked counter and skips the taken number.
            }
        }
    }

    /**
     * Only transient concurrency failures are retried: a duplicate-key
     * violation, a deadlock, or a lock-wait timeout. Any other database
     * error is rethrown immediately.
     */
    private function isRetryable(QueryException $e): bool
    {
        $errorInfo = $e->errorInfo ?? [];
        $driverCode = $errorInfo[1] ?? null;

        // MySQL: 1062 duplicate entry, 1213 deadlock, 1205 lock wait timeout.
        if (in_array($driverCode, [1062, 1213, 1205], true)) {
            return true;
        }

        // Driver-independent fallback (also covers other drivers that
        // report the violation without a numeric code).
        if (stripos($e->getMessage(), 'Duplicate entry') !== false) {
            return true;
        }

        return false;
    }
}
