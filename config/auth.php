<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'attendees',
        ],

        'api' => [
            'driver' => 'sanctum',
            'provider' => 'attendees',
        ],
    ],

    'providers' => [
        'attendees' => [
            'driver' => 'eloquent',
            'model' => App\Models\Attendee::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'attendees',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
