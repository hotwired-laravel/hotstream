<?php

namespace HotwiredLaravel\Hotstream\Tests;

use HotwiredLaravel\Hotstream\Features;
use HotwiredLaravel\Hotstream\HotstreamServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Laravel\Fortify\Features as FortifyFeatures;
use Laravel\Fortify\FortifyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Tonysm\ImportmapLaravel\ImportmapLaravelServiceProvider;
use Tonysm\TailwindCss\TailwindCssServiceProvider;
use Tonysm\TailwindCss\Testing\InteractsWithTailwind;
use Tonysm\TurboLaravel\TurboServiceProvider;

class TestCase extends Orchestra
{
    use InteractsWithTailwind;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ImportmapLaravelServiceProvider::class,
            TailwindCssServiceProvider::class,
            TurboServiceProvider::class,
            HotstreamServiceProvider::class,
            FortifyServiceProvider::class,
        ];
    }

    public function defineEnvironment($app)
    {
        View::addLocation(__DIR__.'/../stubs/resources/views');

        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $this->defineStubDashboardRoute();

        if ($this->hasTeamsFeature ?? false) {
            $this->defineHasTeamEnvironment($app);
        }

        if ($this->hasFortifyFeature ?? false) {
            $this->defineHasFortifyEnvironment($app);
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

    protected function defineHasFortifyEnvironment($app)
    {
        $features = $app->config->get('fortify.features', []);

        $features[] = FortifyFeatures::registration();
        $features[] = FortifyFeatures::resetPasswords();
        $features[] = FortifyFeatures::emailVerification();
        $features[] = FortifyFeatures::updateProfileInformation();
        $features[] = FortifyFeatures::updatePasswords();
        $features[] = FortifyFeatures::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
        ]);

        $app->config->set('fortify.features', $features);
    }

    protected function defineStubDashboardRoute()
    {
        Route::get('/dashboard', function () {
            return 'Dashboard';
        })->name('dashboard');
    }
}
