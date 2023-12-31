<?php

namespace App\Providers;

use App\Actions\Hotstream\DeleteUser;
use HotwiredLaravel\Hotstream\Hotstream;
use HotwiredLaravel\TurboLaravel\Http\PendingTurboStreamResponse;
use Illuminate\Support\ServiceProvider;

class HotstreamServiceProvider extends ServiceProvider
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
        $this->configureTurboMacros();

        Hotstream::deleteUsersUsing(DeleteUser::class);
    }

    private function configurePermissions(): void
    {
        Hotstream::defaultApiTokenPermissions(['read']);

        Hotstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }

    private function configureTurboMacros(): void
    {
        PendingTurboStreamResponse::macro('flash', function (string $message) {
            return turbo_stream()->append('notifications', view('layouts._notification', [
                'message' => $message,
            ]));
        });
    }
}
