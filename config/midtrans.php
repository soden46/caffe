<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | The Midtrans server and client keys, along with the environment setting.
    | These keys should be retrieved from your Midtrans account dashboard.
    |
    */

    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-W4vZ6of3o4uUSbaHY_GUyiMt'),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-0l2t3ENJzYewBJC0'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),

];
