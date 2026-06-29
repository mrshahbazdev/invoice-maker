<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    public const TYPE_MANUAL = 'manual';
    public const TYPE_SCHEDULED = 'scheduled';
    public const TYPE_REMINDER = 'reminder';

    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'invoice_id',
        'business_id',
        'recipient_email',
        'subject',
        'type',
        'status',
        'error_message',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
