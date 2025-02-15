<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],

        'staff' => [ // Add 'staff' guard here
            'driver' => 'session',
            'provider' => 'staffs', // Provider name 'staffs' (plural)
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'staffs' => [ // Add 'staffs' provider here
            'driver' => 'eloquent',
            'model' => App\Models\Staff::class, // Use your Staff model
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'session' => [
        'lifetime' => 120,
        'expire_on_close' => false,
        'encrypt' => false,
        'lottery' => [2, 100],
        'cookie' => 'laravel_session',
        'path' => '/',
        'domain' => null,
        'secure' => false,
        'http_only' => true,
        'same_site' => 'lax',
    ],

    'remember' => [
        'users' => [
            'provider' => 'users',
            'table' => 'remember_token',
        ],
    ],

    'lockout' => [
        'maxAttempts' => 5,
        'decayMinutes' => 1,
    ],

    'password_timeout' => 10800,

];