<?php

return [

    'defaults' => [
        'guard' => 'web', // Default tetap 'web' untuk masyarakat
        'passwords' => 'users',
    ],

    'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'petugas' => [
        'driver' => 'session',
        'provider' => 'petugas',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Masyarakat::class,
        ],

        'petugas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Petugas::class,
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
    
    'password_timeout' => 10800,

];
