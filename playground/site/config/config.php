<?php

return [
    'debug' => true,

    'content' => [
        'locking' => false
    ],

    'panel' => [
        'vue' => [
            'compiler' => false
        ]
    ],

    'johannschopplich.deploy-trigger' => [
        'deployUrl' => env('DEPLOY_TRIGGER_URL')
    ]
];
