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
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
