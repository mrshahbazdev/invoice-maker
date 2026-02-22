<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'logo',
        'currency',
        'timezone',
        'tax_number',
        'bank_details',
        'stripe_account_id',
        'stripe_onboarding_complete',
        'plan',
    ];

    protected $casts = [
        'logo' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function templates()
    {
        return $this->hasMany(Template::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function getCurrencySymbolAttribute()
    {
        return match (strtoupper($this->currency)) {
            'USD', 'CAD', 'AUD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'INR' => '₹',
            'PKR', 'LKR', 'NPR' => 'Rs',
            'AED' => 'د.إ',
            default => '$',
        };
    }
}
