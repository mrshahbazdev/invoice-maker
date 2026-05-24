<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Allocore Integration Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for the Allocore Tools Platform ↔ Invoice Maker bridge.
    | When Allocore users purchase bundles, invoices are auto-created here.
    |
    */

    'api_key' => env('ALLOCORE_API_KEY'),

    'webhook_url' => env('ALLOCORE_WEBHOOK_URL'),

    // Allocore seller business details (used to create the Business entity)
    'business' => [
        'name' => env('ALLOCORE_BUSINESS_NAME', 'Allocore GmbH'),
        'email' => env('ALLOCORE_BUSINESS_EMAIL', 'billing@allocore.com'),
        'tax_number' => env('ALLOCORE_TAX_NUMBER', ''),
        'address' => env('ALLOCORE_BUSINESS_ADDRESS', ''),
        'phone' => env('ALLOCORE_BUSINESS_PHONE', ''),
        'currency' => env('ALLOCORE_CURRENCY', 'EUR'),
        'iban' => env('ALLOCORE_IBAN', ''),
        'bic' => env('ALLOCORE_BIC', ''),
    ],

    // Invoice defaults
    'invoice' => [
        'prefix' => env('ALLOCORE_INVOICE_PREFIX', 'ALC'),
        'default_tax_rate' => (float) env('ALLOCORE_DEFAULT_TAX_RATE', 19),
        'payment_terms_days' => (int) env('ALLOCORE_PAYMENT_TERMS_DAYS', 14),
        'payment_terms_text' => env('ALLOCORE_PAYMENT_TERMS_TEXT', 'Zahlbar innerhalb von 14 Tagen.'),
    ],

];
