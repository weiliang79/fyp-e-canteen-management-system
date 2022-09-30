<?php

return [

      'currency_symbol' => env('CURRENCY_SYMBOL'),

      'maintenance_mode' => env('PAYMENT_MAINTENANCE'),

      '2c2p-status' => env('2C2P_ENABLE'),

      '2c2p-algorithm' => 'HS256',

      '2c2p-sandbox' => [
            'status' => env('2C2P_SANDBOX_ENABLE'),
            'url' => 'https://sandbox-pgw.2c2p.com/payment/4.1/',
            'merchantID' => env('2C2P_SANDBOX_MERCHANT_ID'),
            'currencyCode' => env('2C2P_SANDBOX_CURRENCY_CODE'),
            'secretCode' => env('2C2P_SANDBOX_SECRET_CODE'),
            'localeCode' => ENV('2C2P_SANDBOX_LOCALE_CODE'),
      ],

    '2c2p' => [
        'url' => 'https://sandbox-pgw.2c2p.com/payment/4.1/',
        'merchantID' => env('2C2P_SANDBOX_MERCHANT_ID'),
        'currencyCode' => env('2C2P_SANDBOX_CURRENCY_CODE'),
        'secretCode' => env('2C2P_SANDBOX_SECRET_CODE'),
        'localeCode' => ENV('2C2P_SANDBOX_LOCALE_CODE'),
    ],

      /*'2c2p' => [
            'url' => 'https://pgw.2c2p.com/payment/4.1/',
            'merchantID' => env('2C2P_MERCHANT_ID'),
            'currencyCode' => env('2C2P_CURRENCY_CODE'),
            'secretCode' => env('2C2P_SECRET_CODE'),
            'localeCode' => env('2C2P_LOCALE_CODE'),
      ],*/

      'stripe-status' => env('STRIPE_ENABLE'),
      'stripe-sandbox' => env('STRIPE_SANDBOX'),
];

?>
