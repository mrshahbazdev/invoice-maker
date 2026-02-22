<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::where('email', 'demo@invoicemaker.com')->first();
if ($user) {
    $business = App\Models\Business::where('user_id', $user->id)->first();
    if ($business && !$user->business_id) {
        $user->update(['business_id' => $business->id]);
        echo "Linked user to business.\n";
    }
    if ($user->role !== 'owner') {
        $user->update(['role' => 'owner']);
        echo "Set role to owner.\n";
    }
}

echo "Total Invoices: " . App\Models\Invoice::count() . "\n";
echo "Total Clients: " . App\Models\Client::count() . "\n";
echo "Demo User Business ID: " . ($user->business_id ?? 'NULL') . "\n";
echo "Demo User Role: " . ($user->role ?? 'NULL') . "\n";
