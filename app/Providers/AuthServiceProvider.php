<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\ClientPolicy;
use App\Policies\ProductPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\TemplatePolicy;
use App\Models\Client;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Template;
use App\Models\Expense;
use App\Policies\ExpensePolicy;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Client::class, ClientPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Invoice::class, InvoicePolicy::class);
        Gate::policy(Template::class, TemplatePolicy::class);
        Gate::policy(Expense::class, ExpensePolicy::class);

        Gate::define('manage-team', function ($user, $business) {
            return $user->business_id === $business->id && ($user->isOwner() || $user->isAdmin());
        });
    }
}
