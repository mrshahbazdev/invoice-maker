<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'name',
        'is_default',
        'primary_color',
        'font_family',
        'logo_position',
        'header_style',
        'footer_message',
        'signature_path',
        'payment_terms',
        'show_tax',
        'show_discount',
        'enable_qr',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
