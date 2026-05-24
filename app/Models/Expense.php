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
        'client_id',
        'product_id',
        'category',
        'amount',
        'date',
        'description',
        'partner_name',
        'reference_number',
        'receipt_path',
        'invoice_id',
        'category_id',
        'network_invoice_id',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'client_id' => 'integer',
        'product_id' => 'integer',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
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

    public function networkInvoice()
    {
        return $this->belongsTo(Invoice::class, 'network_invoice_id');
    }
}
