<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_OWNER = 'owner';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_VIEWER = 'viewer';

    protected $fillable = [
        'business_id',
        'name',
        'email',
        'password',
        'role',
        'language',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'is_super_admin',
        'is_active',
        'openai_api_key',
        'anthropic_api_key',
        'default_ai_provider',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'openai_api_key',
        'anthropic_api_key',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_recovery_codes' => 'array',
            'is_super_admin' => 'boolean',
            'is_active' => 'boolean',
            'openai_api_key' => 'encrypted',
            'anthropic_api_key' => 'encrypted',
        ];
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function ownedBusiness()
    {
        return $this->hasOne(Business::class);
    }

    public function isOwner(): bool
    {
        return $this->role === self::ROLE_OWNER;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN || $this->isOwner();
    }

    public function isViewer(): bool
    {
        return $this->role === self::ROLE_VIEWER;
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(InvoiceComment::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketReplies()
    {
        return $this->hasMany(TicketReply::class);
    }
}
