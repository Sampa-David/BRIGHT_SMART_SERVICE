<?php

return [
    'url' => env('SUPABASE_URL'),
    'key' => env('SUPABASE_KEY'),
    'secret' => env('SUPABASE_SECRET'),
    
    'database' => [
        'connection' => env('DB_CONNECTION', 'pgsql'),
        'host' => env('DB_HOST'),
        'port' => env('DB_PORT', '5432'),
        'database' => env('DB_DATABASE', 'postgres'),
        'username' => env('DB_USERNAME', 'postgres'),
        'password' => env('DB_PASSWORD'),
        'ssl_mode' => env('DB_SSLMODE', 'require'),
    ],
];