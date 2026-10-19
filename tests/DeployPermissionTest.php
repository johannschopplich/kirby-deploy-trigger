<?php

declare(strict_types = 1);

use Kirby\Cms\App;
use Kirby\Exception\LogicException;
use Kirby\Exception\PermissionException;
use Kirby\Filesystem\Dir;
use Kirby\Panel\Ui\Buttons\ViewButton;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
final class DeployPermissionTest extends TestCase
{
    private const INDEX_ROOT = __DIR__ . '/tmp/deploy-permission';

    protected function tearDown(): void
    {
        App::destroy();
        Dir::remove(self::INDEX_ROOT);
    }

    #[Test]
    public function shows_the_button_to_a_role_without_a_deploy_entry(): void
    {
        $kirby = $this->app('client@example.com');

        $button = ViewButton::factory(button: 'deploy-trigger', view: 'site', model: $kirby->site());

        $this->assertSame('k-deploy-trigger-view-button', $button?->component);
    }

    #[Test]
    public function hides_the_button_from_a_role_without_the_deploy_permission(): void
    {
        $kirby = $this->app('editor@example.com');

        $this->assertNull(ViewButton::factory(button: 'deploy-trigger', view: 'site', model: $kirby->site()));
        $this->assertNull(ViewButton::factory(button: 'deploy-trigger', view: 'page', model: $kirby->page('home')));
    }

    #[Test]
    public function refuses_the_deploy_hook_to_a_role_without_the_deploy_permission(): void
    {
        $kirby = $this->app('editor@example.com');

        $this->expectException(PermissionException::class);

        $kirby->api()->call('__deploy-trigger__/hook', 'POST');
    }

    #[Test]
    public function lets_a_role_without_a_deploy_entry_through_to_the_deploy_hook(): void
    {
        $kirby = $this->app('client@example.com');

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('The deploy hook could not be reached');

        $kirby->api()->call('__deploy-trigger__/hook', 'POST');
    }

    private function app(string $email): App
    {
        $kirby = new App([
            'roots' => ['index' => self::INDEX_ROOT],
            'options' => [
                'api' => ['allowImpersonation' => true],
                // Nothing listens on port 1, so an allowed request fails fast as unreachable.
                'johannschopplich.deploy-trigger.deployUrl' => 'http://127.0.0.1:1/'
            ],
            'blueprints' => [
                'users/client' => ['name' => 'client'],
                'users/editor' => [
                    'name' => 'editor',
                    'permissions' => [
                        'johannschopplich.deploy-trigger' => ['deploy' => false]
                    ]
                ]
            ],
            'users' => [
                ['email' => 'client@example.com', 'role' => 'client'],
                ['email' => 'editor@example.com', 'role' => 'editor']
            ],
            'site' => [
                'children' => [['slug' => 'home']]
            ]
        ]);

        $kirby->impersonate($email);

        return $kirby;
    }
}
