<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserImpersonatedNotification extends Notification
{
    use Queueable;

    public $adminId;

    /**
     * Create a new notification instance.
     */
    public function __construct(int $adminId)
    {
        $this->adminId = $adminId;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        // Group G: database notification only, no email.
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'admin_id' => $this->adminId,
            'message' => 'Your account was accessed by a super-admin via impersonation.',
            'type' => 'user_impersonated',
            'impersonated_at' => now()->toIso8601String(),
            'url' => route('dashboard'),
        ];
    }
}
