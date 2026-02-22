<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'name',
        'type',
        'booking_account',
        'posting_rule',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function cash_book_entries()
    {
        return $this->hasMany(CashBookEntry::class, 'category_id');
    }
}
