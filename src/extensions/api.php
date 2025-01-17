<?php

use Kirby\Cms\App;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Exception\LogicException;
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
                    throw new InvalidArgumentException('Missing "johannschopplich.deploy-trigger.deployUrl" plugin option');
                }

                $requestOptions = $kirby->option('johannschopplich.deploy-trigger.requestOptions', []);

                $response = Remote::request(
                    $deployUrl,
                    A::merge(['method' => 'POST'], $requestOptions)
                );

                if ($response->code() < 200 || $response->code() >= 300) {
                    throw new LogicException('Deployment request failed: ' . $response->content());
                }

                return [
                    'status' => 'ok',
                    'code' => 200,
                    'data' => $response->content()
                ];
            }
        ]
    ]
];
