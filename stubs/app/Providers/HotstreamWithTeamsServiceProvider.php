<?php

namespace App\Providers;

use App\Actions\Hotstream\AddTeamMember;
use App\Actions\Hotstream\CreateTeam;
use App\Actions\Hotstream\DeleteTeam;
use App\Actions\Hotstream\DeleteUser;
use App\Actions\Hotstream\InviteTeamMember;
use App\Actions\Hotstream\RemoveTeamMember;
use App\Actions\Hotstream\UpdateTeamName;
use App\Actions\Hotstream\UpdateUserPicture;
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

        Hotstream::createTeamsUsing(CreateTeam::class);
        Hotstream::updateTeamNamesUsing(UpdateTeamName::class);
        Hotstream::addTeamMembersUsing(AddTeamMember::class);
        Hotstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Hotstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Hotstream::deleteTeamsUsing(DeleteTeam::class);
        Hotstream::deleteUsersUsing(DeleteUser::class);
        Hotstream::updateUserPictureUsing(UpdateUserPicture::class);
    }

    private function configurePermissions(): void
    {
        Hotstream::defaultApiTokenPermissions(['read']);

        Hotstream::role('admin', 'Administrator', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('Administrator users can perform any action.');

        Hotstream::role('editor', 'Editor', [
            'read',
            'create',
            'update',
        ])->description('Editor users have the ability to read, create, and update.');
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
