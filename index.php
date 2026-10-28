<?php

use Kirby\Cms\App;
use Kirby\Exception\LogicException;

if (version_compare(App::version() ?? '0', '6.0.0-beta', '<')) {
    throw new LogicException('Kirby Deploy Trigger requires Kirby 6');
}

App::plugin('johannschopplich/deploy-trigger', [
    // Role blueprints set this to `false` to refuse the deploy request and hide the button.
    'permissions' => [
        'deploy' => true
    ],
    'areas' => require __DIR__ . '/src/extensions/areas.php',
    'api' => require __DIR__ . '/src/extensions/api.php',
    'translations' => require __DIR__ . '/src/extensions/translations.php'
]);
