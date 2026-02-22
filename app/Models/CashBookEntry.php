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
        'date',
        'amount',
        'type',
        'source',
        'description',
        'category_id',
        'invoice_id',
        'expense_id',
    ];

    protected $casts = [
        'date' => 'date',
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
        $year = now()->year;
        $lastEntry = static::where('business_id', $businessId)
            ->whereYear('date', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;

        if ($lastEntry && $lastEntry->booking_number) {
            // Format is 01-2026
            $parts = explode('-', $lastEntry->booking_number);
            if (count($parts) === 2) {
                $nextNumber = (int) $parts[0] + 1;
            }
        }

        return str_pad($nextNumber, 2, '0', STR_PAD_LEFT) . '-' . $year;
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
