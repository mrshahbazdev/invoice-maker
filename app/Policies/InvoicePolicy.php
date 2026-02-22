<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    public function view(?User $user, Invoice $invoice): bool
    {
        if (!$user) {
            return true; // Allow guests for public views, routes handle the rest
        }
        return $invoice->business->user_id === $user->id || $invoice->client->user_id === $user->id;
    }

    public function update(?User $user, Invoice $invoice): bool
    {
        return $user && $invoice->business->user_id === $user->id;
    }

    public function delete(?User $user, Invoice $invoice): bool
    {
        return $user && $invoice->business->user_id === $user->id;
    }
}
