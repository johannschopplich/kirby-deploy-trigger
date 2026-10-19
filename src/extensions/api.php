<?php

use Kirby\Cms\App;
use Kirby\Exception\Exception as KirbyException;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Exception\LogicException;
use Kirby\Exception\PermissionException;
use Kirby\Http\Remote;
use Kirby\Toolkit\I18n;
use Kirby\Toolkit\Str;

return [
    'routes' => fn (App $kirby) => [
        [
            'pattern' => '__deploy-trigger__/hook',
            'method' => 'POST',
            'action' => function () use ($kirby) {
                if ($kirby->user()?->role()->permissions()->for('johannschopplich.deploy-trigger', 'deploy') !== true) {
                    throw new PermissionException();
                }

                $deployUrl = $kirby->option('johannschopplich.deploy-trigger.deployUrl');

                if (!$deployUrl) {
                    throw new InvalidArgumentException('Missing "johannschopplich.deploy-trigger.deployUrl" plugin option');
                }

                $requestOptions = $kirby->option('johannschopplich.deploy-trigger.requestOptions', []);

                try {
                    $response = Remote::request($deployUrl, [
                        'method' => 'POST',
                        ...$requestOptions
                    ]);
                } catch (KirbyException $e) {
                    // A Kirby exception, such as an invalid `ca` option, already names its cause.
                    throw $e;
                } catch (Exception $e) {
                    // Outside debug mode, Kirby hides a curl error (DNS, timeout) behind "An unexpected error occurred".
                    throw new LogicException(I18n::translate('johannschopplich.deploy-trigger.error.unreachable') . ': ' . $e->getMessage());
                }

                $code = $response->code();

                if ($code < 200 || $code >= 300) {
                    $message = I18n::template('johannschopplich.deploy-trigger.error.status', null, ['status' => $code]);
                    $body = trim($response->content() ?? '');

                    // Append a plain-text or JSON reason, but not an HTML error page.
                    if ($body !== '' && !str_starts_with($body, '<')) {
                        $message .= ': ' . Str::short($body, 200);
                    }

                    throw new LogicException($message);
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
