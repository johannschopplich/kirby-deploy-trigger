<?php

return [
    'debug' => true,

    'content' => [
        'locking' => false
    ],

    'johannschopplich.deploy-trigger' => [
        'deployUrl' => env('DEPLOY_TRIGGER_URL')
    ]
];
