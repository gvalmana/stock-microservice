<?php
return [
    'delivery_microservice' =>[
        'url' => env('STOCK_INGREDIENTS_URL', 'http://localhost:8000/api'),
        'webhook_order_path' => env('STOCK_INGREDIENTS_WEBHOOK_ORDER_PATH', '/webhook/orders'),
    ],
    'comomunication_protocol' => env('APP_COMUNICATION_PROTOCOL', 'http'),
    'marketplace' => [
        'url' => env('ALEGRIA_MARKETPLACE_URL', 'https://recruitment.alegra.com/api/farmers-market/buy'),
        'available' => env('ALEGRIA_MARKETPLACE_AVAILABLE', 0),
    ],
    'comunication_protocol' => env('APP_COMUNICATION_PROTOCOL', 'http'),
    'security_key' => env('APP_SECURITY_KEY'),
];
