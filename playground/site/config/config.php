<?php

return [
    'debug' => env('KIRBY_DEBUG', false),

    'content' => [
        'locking' => false
    ],

    'johannschopplich.deploy-trigger' => [
        'deployUrl' => env('DEPLOY_TRIGGER_URL')
    ]
];
