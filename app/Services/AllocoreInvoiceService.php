<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AllocoreInvoiceService
{
    protected InvoiceNumberService $numberService;

    public function __construct(InvoiceNumberService $numberService)
    {
        $this->numberService = $numberService;
    }

    protected function cfg(string $key, mixed $default = null): mixed
    {
        $dbKey = 'allocore.' . $key;
        $dbVal = \App\Models\Setting::get($dbKey);
        if ($dbVal !== null && $dbVal !== '') {
            return $dbVal;
        }

        $configMap = [
            'business_name' => 'allocore.business.name',
            'business_email' => 'allocore.business.email',
            'tax_number' => 'allocore.business.tax_number',
            'business_address' => 'allocore.business.address',
            'business_phone' => 'allocore.business.phone',
            'currency' => 'allocore.business.currency',
            'iban' => 'allocore.business.iban',
            'bic' => 'allocore.business.bic',
            'invoice_prefix' => 'allocore.invoice.prefix',
            'default_tax_rate' => 'allocore.invoice.default_tax_rate',
            'payment_terms_days' => 'allocore.invoice.payment_terms_days',
            'payment_terms_text' => 'allocore.invoice.payment_terms_text',
            'webhook_url' => 'allocore.webhook_url',
        ];

        if (isset($configMap[$key])) {
            return config($configMap[$key], $default);
        }

        return $default;
    }

    /**
     * Get or create the Allocore seller Business entity.
     */
    public function getOrCreateAllocoreBusiness(): Business
    {
        $cfg = [
            'name' => $this->cfg('business_name', 'Allocore GmbH'),
            'email' => $this->cfg('business_email', 'billing@allocore.com'),
            'tax_number' => $this->cfg('tax_number', ''),
            'address' => $this->cfg('business_address', ''),
            'phone' => $this->cfg('business_phone', ''),
            'currency' => $this->cfg('currency', 'EUR'),
            'iban' => $this->cfg('iban', ''),
            'bic' => $this->cfg('bic', ''),
        ];

        $business = Business::where('email', $cfg['email'])->first();

        if ($business) {
            return $business;
        }

        $owner = User::where('email', $cfg['email'])->first();

        if (!$owner) {
            $owner = User::create([
                'name' => $cfg['name'],
                'email' => $cfg['email'],
                'password' => bcrypt(str()->random(32)),
                'role' => User::ROLE_OWNER,
                'is_active' => true,
            ]);
        }

        return Business::create([
            'user_id' => $owner->id,
            'name' => $cfg['name'],
            'email' => $cfg['email'],
            'tax_number' => $cfg['tax_number'],
            'address' => $cfg['address'],
            'phone' => $cfg['phone'],
            'currency' => $cfg['currency'],
            'iban' => $cfg['iban'],
            'bic' => $cfg['bic'],
            'invoice_number_prefix' => $this->cfg('invoice_prefix', 'ALC'),
            'invoice_number_next' => 1,
        ]);
    }

    /**
     * Sync an Allocore user to a Client record.
     */
    public function syncClient(array $userData): Client
    {
        $business = $this->getOrCreateAllocoreBusiness();

        $client = Client::where('allocore_user_id', $userData['id'])
            ->where('business_id', $business->id)
            ->first();

        if ($client) {
            $client->update([
                'name' => $userData['name'] ?? $client->name,
                'email' => $userData['email'] ?? $client->email,
                'company_name' => $userData['company'] ?? $client->company_name,
                'phone' => $userData['phone'] ?? $client->phone,
            ]);

            return $client;
        }

        return Client::create([
            'business_id' => $business->id,
            'allocore_user_id' => $userData['id'],
            'name' => $userData['name'] ?? 'Unknown',
            'email' => $userData['email'] ?? '',
            'company_name' => $userData['company'] ?? null,
            'phone' => $userData['phone'] ?? null,
            'currency' => $this->cfg('currency', 'EUR'),
            'source' => 'allocore',
        ]);
    }

    /**
     * Create a proper invoice from an Allocore order.
     */
    public function createInvoiceFromOrder(array $orderData): Invoice
    {
        $business = $this->getOrCreateAllocoreBusiness();
        $client = $this->syncClient($orderData['user']);

        $existing = Invoice::where('allocore_order_id', $orderData['order_id'])
            ->where('business_id', $business->id)
            ->first();

        if ($existing) {
            return $existing;
        }

        $taxRate = (float) $this->cfg('default_tax_rate', 19);
        $netAmount = (float) $orderData['amount'];
        $taxAmount = round($netAmount * ($taxRate / 100), 2);
        $grossAmount = $netAmount + $taxAmount;
        $termsDays = (int) $this->cfg('payment_terms_days', 14);

        return DB::transaction(function () use (
            $business, $client, $orderData, $taxRate, $netAmount, $taxAmount, $grossAmount, $termsDays
        ) {
            $invoiceNumber = $this->numberService->generate($business);

            $interval = $orderData['interval'] ?? 'monthly';
            $isRecurring = in_array($interval, ['monthly', 'yearly']);

            $invoice = Invoice::create([
                'business_id' => $business->id,
                'client_id' => $client->id,
                'allocore_order_id' => $orderData['order_id'],
                'allocore_subscription_id' => $orderData['subscription_id'] ?? null,
                'invoice_number' => $invoiceNumber,
                'status' => $orderData['status'] === 'paid' ? Invoice::STATUS_PAID : Invoice::STATUS_SENT,
                'invoice_date' => now(),
                'due_date' => now()->addDays($termsDays),
                'currency' => $orderData['currency'] ?? 'EUR',
                'subtotal' => $netAmount,
                'tax_total' => $taxAmount,
                'discount' => 0,
                'grand_total' => $grossAmount,
                'amount_paid' => $orderData['status'] === 'paid' ? $grossAmount : 0,
                'amount_due' => $orderData['status'] === 'paid' ? 0 : $grossAmount,
                'notes' => $orderData['notes'] ?? null,
                'payment_terms' => $this->cfg('payment_terms_text', 'Zahlbar innerhalb von 14 Tagen.'),
                'source' => 'allocore',
                'is_recurring' => $isRecurring,
                'recurring_frequency' => $isRecurring ? $interval : null,
                'next_run_date' => $isRecurring
                    ? ($interval === 'yearly' ? now()->addYear() : now()->addMonth())
                    : null,
            ]);

            $tools = $orderData['tools'] ?? [];
            $bundle = $orderData['bundle'] ?? 'Bundle';

            if (count($tools) > 0) {
                $pricePerTool = $netAmount / count($tools);

                foreach ($tools as $toolName) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'description' => "Allocore Tool: {$toolName}",
                        'quantity' => 1,
                        'unit_price' => round($pricePerTool, 2),
                        'tax_rate' => $taxRate,
                        'tax_amount' => round($pricePerTool * ($taxRate / 100), 2),
                        'discount' => 0,
                        'total' => round($pricePerTool * (1 + $taxRate / 100), 2),
                    ]);
                }
            } else {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => "Allocore {$bundle} Bundle",
                    'quantity' => 1,
                    'unit_price' => $netAmount,
                    'tax_rate' => $taxRate,
                    'tax_amount' => $taxAmount,
                    'discount' => 0,
                    'total' => $grossAmount,
                ]);
            }

            return $invoice;
        });
    }

    /**
     * Record a payment against an invoice.
     */
    public function recordPayment(Invoice $invoice, array $paymentData): Payment
    {
        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $paymentData['amount'],
            'method' => $paymentData['method'] ?? 'bank_transfer',
            'date' => $paymentData['date'] ?? now()->toDateString(),
            'notes' => $paymentData['notes'] ?? 'Allocore platform payment',
        ]);

        $totalPaid = $invoice->payments()->sum('amount');
        $invoice->update([
            'amount_paid' => $totalPaid,
            'amount_due' => max(0, $invoice->grand_total - $totalPaid),
            'status' => $totalPaid >= $invoice->grand_total ? Invoice::STATUS_PAID : $invoice->status,
        ]);

        return $payment;
    }

    /**
     * Update invoice status and optionally notify Allocore via webhook.
     */
    public function updateStatus(Invoice $invoice, string $status): Invoice
    {
        $invoice->update(['status' => $status]);

        $this->notifyAllocore($invoice);

        return $invoice;
    }

    /**
     * Send webhook notification to Allocore about invoice status change.
     */
    protected function notifyAllocore(Invoice $invoice): void
    {
        $webhookUrl = $this->cfg('webhook_url');

        if (!$webhookUrl || !$invoice->allocore_order_id) {
            return;
        }

        try {
            \Illuminate\Support\Facades\Http::post($webhookUrl, [
                'event' => 'invoice.status_changed',
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'allocore_order_id' => $invoice->allocore_order_id,
                'status' => $invoice->status,
                'amount_due' => $invoice->amount_due,
                'grand_total' => $invoice->grand_total,
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to notify Allocore: ' . $e->getMessage());
        }
    }
}
