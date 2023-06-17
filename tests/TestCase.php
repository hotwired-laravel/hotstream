<?php

namespace Hotwired\Hotstream\Tests;

use Hotwired\Hotstream\Features;
use Hotwired\Hotstream\HotstreamServiceProvider;
use Laravel\Fortify\FortifyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            HotstreamServiceProvider::class,
            FortifyServiceProvider::class,
        ];
    }

    public function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        if ($this->hasTeamsFeature ?? false) {
            $this->defineHasTeamEnvironment($app);
        }
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadMigrationsFrom(__DIR__.'/../vendor/laravel/fortify/database/migrations');
    }

    protected function defineHasTeamEnvironment($app)
    {
        $features = $app->config->get('hotstream.features', []);

        $features[] = Features::teams(['invitations' => true]);

        $app->config->set('hotstream.features', $features);
    }
}
