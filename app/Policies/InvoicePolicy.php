<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    public function view(?User $user, Invoice $invoice): bool
    {
        if (!$user) {
            return false; // Guests use signed public links, never the policy
        }
        return $invoice->business_id === $user->business_id;
    }

    public function update(?User $user, Invoice $invoice): bool
    {
        return $user && $invoice->business_id === $user->business_id && $user->isAdmin();
    }

    public function delete(?User $user, Invoice $invoice): bool
    {
        return $user && $invoice->business_id === $user->business_id && $user->isAdmin();
    }
}
