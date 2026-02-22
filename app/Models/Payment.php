<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'amount',
        'method',
        'date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

    public const METHOD_BANK_TRANSFER = 'bank_transfer';
    public const METHOD_CREDIT_CARD = 'credit_card';
    public const METHOD_CASH = 'cash';
    public const METHOD_CHECK = 'check';
    public const METHOD_PAYPAL = 'paypal';
    public const METHOD_STRIPE = 'stripe';

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
