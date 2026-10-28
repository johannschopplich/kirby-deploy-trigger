<?php

use Kirby\Cms\User;

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
