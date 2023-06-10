<?php

namespace Hotwired\Hotstream;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Hotwired\Hotstream\Commands\HotstreamCommand;

class HotstreamServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('hotstream')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_hotstream_table')
            ->hasCommand(HotstreamCommand::class);
    }
}
