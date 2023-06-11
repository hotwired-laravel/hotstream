<?php

namespace App\Providers;

use App\Actions\Hotstream\DeleteUser;
use Hotwired\Hotstream\Hotstream;
use Illuminate\Support\ServiceProvider;
use Tonysm\TurboLaravel\Http\PendingTurboStreamResponse;

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
