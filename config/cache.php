<?php

return [

    'default' => env('CACHE_STORE', 'database'),

    'stores' => [

        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
        ],

        'database' => [
            'driver' => 'database',
            'table' => env('DB_CACHE_TABLE', 'cache'),
            'connection' => null,
            'lock_connection' => null,
        ],

    ],

    'prefix' => env('CACHE_PREFIX', \Illuminate\Support\Str::slug(env('APP_NAME', 'laravel'), '_') . '_cache_'),

];
