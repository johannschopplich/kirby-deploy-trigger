<?php

use Kirby\Cms\App;

App::plugin('johannschopplich/deploy-trigger', [
    'api' => require __DIR__ . '/src/extensions/api.php',
    'translations' => require __DIR__ . '/src/extensions/translations.php'
]);
