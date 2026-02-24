<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'user_id',
        'name',
        'email',
        'phone',
        'company_name',
        'address',
        'tax_number',
        'currency',
        'language',
        'notes',
        'email_subject',
        'email_template',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
