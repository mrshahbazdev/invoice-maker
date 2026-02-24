<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashBookEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'booking_number',
        'reference_number',
        'date',
        'document_date',
        'amount',
        'type',
        'source',
        'description',
        'partner_name',
        'category_id',
        'invoice_id',
        'expense_id',
    ];

    protected $casts = [
        'date' => 'date',
        'document_date' => 'date',
        'amount' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($entry) {
            if (!$entry->booking_number) {
                $entry->booking_number = static::generateBookingNumber($entry->business_id);
            }
        });
    }

    public static function generateBookingNumber($businessId)
    {
        $business = Business::find($businessId);

        $prefix = $business->booking_number_prefix ?? 'EXP';
        $next = $business->booking_number_next ?? 1;
        $year = now()->year;

        // Ensure uniqueness
        $number = "{$prefix}-" . str_pad($next, 4, '0', STR_PAD_LEFT) . "-{$year}";
        while (
            static::where('business_id', $businessId)
                ->where('booking_number', $number)
                ->exists()
        ) {
            $next++;
            $number = "{$prefix}-" . str_pad($next, 4, '0', STR_PAD_LEFT) . "-{$year}";
        }

        // Increment for next time
        $business->update(['booking_number_next' => $next + 1]);

        return $number;
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function category()
    {
        return $this->belongsTo(AccountingCategory::class, 'category_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
