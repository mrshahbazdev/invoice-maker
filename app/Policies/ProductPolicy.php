<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function view(User $user, Product $product): bool
    {
        return $product->business_id === $user->business_id;
    }

    public function update(User $user, Product $product): bool
    {
        return $product->business_id === $user->business_id && $user->isAdmin();
    }

    public function delete(User $user, Product $product): bool
    {
        return $product->business_id === $user->business_id && $user->isAdmin();
    }
}
