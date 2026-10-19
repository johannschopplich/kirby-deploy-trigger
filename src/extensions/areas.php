<?php

use Kirby\Cms\App;
use Kirby\Cms\User;

// Kirby 4 has no view buttons and would call the button closure without arguments.
if (version_compare(App::version() ?? '0', '5.0.0', '<')) {
    return [];
}

return [
    'site' => fn () => [
        'buttons' => [
            // Kirby finds the button by name in every view; `null` hides it.
            'deploy-trigger' => function (User|null $user) {
                if ($user?->role()->permissions()->for('johannschopplich.deploy-trigger', 'deploy') !== true) {
                    return null;
                }

                return [];
            }
        ]
    ]
];
