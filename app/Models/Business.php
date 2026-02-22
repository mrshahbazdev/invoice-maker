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
        'invoice_number_prefix',
        'invoice_number_next',
    ];

    protected $casts = [
        'logo' => 'array',
    ];

    protected static function booted()
    {
        static::created(function ($business) {
            $business->seedDefaultTemplates();
        });
    }

    public function seedDefaultTemplates()
    {
        $templates = [
            [
                'name' => 'Minimalist Professional',
                'primary_color' => '#1f2937',
                'font_family' => 'Helvetica, sans-serif',
                'header_style' => 'simple',
                'show_tax' => true,
                'show_discount' => true,
                'is_default' => true,
                'payment_terms' => 'Please pay within 15 days.',
                'footer_message' => 'Thank you for your business!',
                'enable_qr' => true,
            ],
            [
                'name' => 'Creative Studio Orange',
                'primary_color' => '#f97316',
                'font_family' => 'Arial, sans-serif',
                'header_style' => 'bold',
                'show_tax' => true,
                'show_discount' => true,
                'is_default' => false,
                'payment_terms' => 'Net 30 days. Late fees apply.',
                'footer_message' => 'We appreciate your creative collaboration.',
                'enable_qr' => true,
            ],
            [
                'name' => 'Tech Startup Blue',
                'primary_color' => '#3b82f6',
                'font_family' => 'Courier New, monospace',
                'header_style' => 'center',
                'show_tax' => true,
                'show_discount' => false,
                'is_default' => false,
                'payment_terms' => 'Payable upon receipt.',
                'footer_message' => 'Built with code & coffee.',
                'enable_qr' => true,
            ],
            [
                'name' => 'Elegant Emerald',
                'primary_color' => '#10b981',
                'font_family' => 'Georgia, serif',
                'header_style' => 'simple',
                'show_tax' => true,
                'show_discount' => true,
                'is_default' => false,
                'payment_terms' => 'Due in 7 days.',
                'footer_message' => 'Partnering for your success.',
                'enable_qr' => false,
            ],
            [
                'name' => 'Corporate Navy',
                'primary_color' => '#1e3a8a',
                'font_family' => 'Times New Roman, serif',
                'header_style' => 'bold',
                'show_tax' => true,
                'show_discount' => true,
                'is_default' => false,
                'payment_terms' => 'Standard Net 30 terms.',
                'footer_message' => 'Reliable & Professional Service.',
                'enable_qr' => true,
            ],
            [
                'name' => 'Modern Purple',
                'primary_color' => '#8b5cf6',
                'font_family' => 'Trebuchet MS, sans-serif',
                'header_style' => 'center',
                'show_tax' => false,
                'show_discount' => true,
                'is_default' => false,
                'payment_terms' => 'Payment due before starting project phase 2.',
                'footer_message' => 'Designing the future.',
                'enable_qr' => true,
            ],
            [
                'name' => 'Sunset Red',
                'primary_color' => '#ef4444',
                'font_family' => 'Verdana, sans-serif',
                'header_style' => 'simple',
                'show_tax' => true,
                'show_discount' => false,
                'is_default' => false,
                'payment_terms' => 'Please initiate wire transfer immediately.',
                'footer_message' => 'Fast and secure.',
                'enable_qr' => false,
            ],
            [
                'name' => 'Boutique Rose',
                'primary_color' => '#f43f5e',
                'font_family' => 'Palatino, serif',
                'header_style' => 'bold',
                'show_tax' => true,
                'show_discount' => true,
                'is_default' => false,
                'payment_terms' => 'Payable via credit card link below.',
                'footer_message' => 'Thank you for shopping local!',
                'enable_qr' => true,
            ],
            [
                'name' => 'Midnight Black',
                'primary_color' => '#000000',
                'font_family' => 'Impact, sans-serif',
                'header_style' => 'center',
                'show_tax' => true,
                'show_discount' => true,
                'is_default' => false,
                'payment_terms' => 'Strictly 14 days.',
                'footer_message' => 'Premium Quality Delivered.',
                'enable_qr' => true,
            ],
            [
                'name' => 'Eco Green',
                'primary_color' => '#65a30d',
                'font_family' => 'Arial, Helvetica, sans-serif',
                'header_style' => 'simple',
                'show_tax' => true,
                'show_discount' => true,
                'is_default' => false,
                'payment_terms' => 'Pay to our eco-friendly digital wallet.',
                'footer_message' => 'Save paper. Keep this digital!',
                'enable_qr' => true,
            ]
        ];

        foreach ($templates as $tmpl) {
            $this->templates()->updateOrCreate(
                ['name' => $tmpl['name']],
                $tmpl
            );
        }
    }

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
