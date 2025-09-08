<?php

return [

    'defaults' => [
        'guard' => 'web', // default guard untuk masyarakat
        'passwords' => 'masyarakat',
    ],

    'guards' => [
        // Guard default web (masyarakat)
        'web' => [
            'driver' => 'session',
            'provider' => 'masyarakat',
        ],

        'masyarakat' => [
            'driver' => 'session',
            'provider' => 'masyarakat',
        ],

        // Guard admin (dari table petugas)
        'admin' => [
            'driver' => 'session',
            'provider' => 'petugas',
        ],

        // Guard petugas (dari table petugas)
        'petugas' => [
            'driver' => 'session',
            'provider' => 'petugas',
        ],
    ],

    'providers' => [
        'masyarakat' => [
            'driver' => 'eloquent',
            'model' => App\Models\Masyarakat::class,
        ],

        'petugas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Petugas::class,
        ],
    ],

    'passwords' => [
        'masyarakat' => [
            'provider' => 'masyarakat',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'petugas' => [
            'provider' => 'petugas',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admin' => [
            'provider' => 'petugas',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
