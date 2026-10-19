<?php

use Kirby\Cms\App;

App::plugin('johannschopplich/deploy-trigger', [
    // Role blueprints set this to `false` to refuse the deploy request and, on Kirby 5, hide the button.
    'permissions' => [
        'deploy' => true
    ],
    'areas' => require __DIR__ . '/src/extensions/areas.php',
    'api' => require __DIR__ . '/src/extensions/api.php',
    'translations' => require __DIR__ . '/src/extensions/translations.php'
]);
