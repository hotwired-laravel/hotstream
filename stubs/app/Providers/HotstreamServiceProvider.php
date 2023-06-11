<?php

namespace App\Providers;

use App\Actions\Hotstream\DeleteUser;
use Hotwired\Hotstream\Facades\Hotstream;
use Illuminate\Support\ServiceProvider;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Hotstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Hotstream::defaultApiTokenPermissions(['read']);

        Hotstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
