<?php

namespace Hotwired\Hotstream\Tests;

use Hotwired\Hotstream\Features;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Hotwired\Hotstream\HotstreamServiceProvider;
use Laravel\Fortify\FortifyServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Hotwired\\Hotstream\\Hotstream\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
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
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
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
