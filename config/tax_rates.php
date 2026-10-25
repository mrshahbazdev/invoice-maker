<?php

// Common standard tax rates by country (ISO 3166-1 alpha-2).
// These are PRESETS only: the business profile pre-fills the rate when a
// country is picked, and the owner can always change it. Rates change by
// law and vary by goods/services/state, so the app never claims a rate is
// legally definitive for a specific invoice.
return [
    'DE' => ['name' => 'Germany', 'label' => 'VAT', 'rate' => 19],
    'FR' => ['name' => 'France', 'label' => 'VAT', 'rate' => 20],
    'GB' => ['name' => 'United Kingdom', 'label' => 'VAT', 'rate' => 20],
    'IT' => ['name' => 'Italy', 'label' => 'VAT', 'rate' => 22],
    'ES' => ['name' => 'Spain', 'label' => 'VAT', 'rate' => 21],
    'NL' => ['name' => 'Netherlands', 'label' => 'VAT', 'rate' => 21],
    'BE' => ['name' => 'Belgium', 'label' => 'VAT', 'rate' => 21],
    'AT' => ['name' => 'Austria', 'label' => 'VAT', 'rate' => 20],
    'PL' => ['name' => 'Poland', 'label' => 'VAT', 'rate' => 23],
    'CH' => ['name' => 'Switzerland', 'label' => 'VAT', 'rate' => 8.1],
    'IE' => ['name' => 'Ireland', 'label' => 'VAT', 'rate' => 23],
    'PT' => ['name' => 'Portugal', 'label' => 'VAT', 'rate' => 23],
    'SE' => ['name' => 'Sweden', 'label' => 'VAT', 'rate' => 25],
    'DK' => ['name' => 'Denmark', 'label' => 'VAT', 'rate' => 25],
    'NO' => ['name' => 'Norway', 'label' => 'VAT', 'rate' => 25],
    'FI' => ['name' => 'Finland', 'label' => 'VAT', 'rate' => 25.5],
    'TR' => ['name' => 'Turkey', 'label' => 'VAT', 'rate' => 20],
    'AE' => ['name' => 'United Arab Emirates', 'label' => 'VAT', 'rate' => 5],
    'SA' => ['name' => 'Saudi Arabia', 'label' => 'VAT', 'rate' => 15],
    'IN' => ['name' => 'India', 'label' => 'GST', 'rate' => 18],
    'PK' => ['name' => 'Pakistan', 'label' => 'GST', 'rate' => 18],
    'BD' => ['name' => 'Bangladesh', 'label' => 'VAT', 'rate' => 15],
    'AU' => ['name' => 'Australia', 'label' => 'GST', 'rate' => 10],
    'NZ' => ['name' => 'New Zealand', 'label' => 'GST', 'rate' => 15],
    'SG' => ['name' => 'Singapore', 'label' => 'GST', 'rate' => 9],
    'JP' => ['name' => 'Japan', 'label' => 'Consumption Tax', 'rate' => 10],
    'KR' => ['name' => 'South Korea', 'label' => 'VAT', 'rate' => 10],
    'ZA' => ['name' => 'South Africa', 'label' => 'VAT', 'rate' => 15],
    'EG' => ['name' => 'Egypt', 'label' => 'VAT', 'rate' => 14],
    'NG' => ['name' => 'Nigeria', 'label' => 'VAT', 'rate' => 7.5],
    'KE' => ['name' => 'Kenya', 'label' => 'VAT', 'rate' => 16],
    'MY' => ['name' => 'Malaysia', 'label' => 'SST', 'rate' => 8],
    'US' => ['name' => 'United States', 'label' => 'Sales Tax', 'rate' => 0],
    'CA' => ['name' => 'Canada', 'label' => 'GST', 'rate' => 5],
    'MX' => ['name' => 'Mexico', 'label' => 'VAT', 'rate' => 16],
    'BR' => ['name' => 'Brazil', 'label' => 'ICMS', 'rate' => 17],
];
