<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon $date
 * @property-read \App\Models\Business $business
 */
class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'category',
        'amount',
        'date',
        'description',
        'receipt_path',
        'invoice_id',
        'category_id',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function accounting_category()
    {
        return $this->belongsTo(AccountingCategory::class, 'category_id');
    }

    public function cash_book_entry()
    {
        return $this->hasOne(CashBookEntry::class);
    }
}
