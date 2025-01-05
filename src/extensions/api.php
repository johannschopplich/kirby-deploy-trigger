<?php

use Kirby\Cms\App;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Http\Remote;
use Kirby\Toolkit\A;

return [
    'routes' => fn (App $kirby) => [
        [
            'pattern' => '__deploy-trigger__/hook',
            'method' => 'POST',
            'action' => function () use ($kirby) {
                $deployUrl = $kirby->option('johannschopplich.deploy-trigger.deployUrl');

                if (!$deployUrl) {
                    throw new InvalidArgumentException('Deploy URL not set');
                }

                $requestOptions = $kirby->option('johannschopplich.deploy-trigger.requestOptions', []);

                // Forward exceptions to the Kirby Panel, don't throw them here
                $response = Remote::request(
                    $deployUrl,
                    A::merge(['method' => 'POST'], $requestOptions)
                );

                return [
                    'ok' => true,
                    'data' => $response->content()
                ];
            }
        ]
    ]
];
