<?php

namespace App\Services;

use App\Models\Business;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;

class MailConfigurationService
{
    /**
     * Configure and return a mailer instance for the given business.
     */
    public static function getMailer(Business $business)
    {
        if (!$business->hasCustomSmtp()) {
            return Mail::mailer();
        }

        $config = [
            'transport' => 'smtp',
            'host' => $business->smtp_host,
            'port' => $business->smtp_port,
            'encryption' => $business->smtp_encryption,
            'username' => $business->smtp_username,
            'password' => $business->smtp_password,
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN'),
        ];

        // For Laravel 10+, we can use Mail::build() to create a temporary mailer
        return Mail::build($config);
    }

    /**
     * Get the transport instance directly for testing.
     */
    public static function getTransport(array $smtpData)
    {
        return new EsmtpTransport(
            $smtpData['host'],
            $smtpData['port'],
            $smtpData['encryption'] === 'tls',
            null,
            null
        );
    }
}
