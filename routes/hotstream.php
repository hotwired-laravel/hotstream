<?php

use HotwiringLaravel\Hotstream\Hotstream;
use HotwiringLaravel\Hotstream\Http\Controllers\AcceptedTeamInvitationsController;
use HotwiringLaravel\Hotstream\Http\Controllers\AccountsController;
use HotwiringLaravel\Hotstream\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use HotwiringLaravel\Hotstream\Http\Controllers\CurrentTeamsController;
use HotwiringLaravel\Hotstream\Http\Controllers\DeletedDeviceSessionsController;
use HotwiringLaravel\Hotstream\Http\Controllers\DeviceSessionsController;
use HotwiringLaravel\Hotstream\Http\Controllers\EnabledTwoFactorAuthenticationController;
use HotwiringLaravel\Hotstream\Http\Controllers\PasswordController;
use HotwiringLaravel\Hotstream\Http\Controllers\PrivacyPolicyController;
use HotwiringLaravel\Hotstream\Http\Controllers\ProfileController;
use HotwiringLaravel\Hotstream\Http\Controllers\ProfilePictureController;
use HotwiringLaravel\Hotstream\Http\Controllers\RecoveryCodesController;
use HotwiringLaravel\Hotstream\Http\Controllers\TeamInvitationsController;
use HotwiringLaravel\Hotstream\Http\Controllers\TeamsController;
use HotwiringLaravel\Hotstream\Http\Controllers\TeamUserRoleController;
use HotwiringLaravel\Hotstream\Http\Controllers\TeamUsersController;
use HotwiringLaravel\Hotstream\Http\Controllers\TermsOfServiceController;
use HotwiringLaravel\Hotstream\Http\Controllers\TwoFactorAuthenticationController;
use HotwiringLaravel\Hotstream\Http\Controllers\UserApiTokensController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => config('hotstream.middleware', ['web'])], function () {
    if (Hotstream::hasTermsAndPrivacyPolicyFeature()) {
        Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
        Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
    }

    $authMiddleware = config('hotstream.guard')
        ? 'auth:'.config('hotstream.guard')
        : 'auth';

    $authSessionMiddleware = config('hotstream.auth_session', false)
        ? config('hotstream.auth_session')
        : null;

    Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware]))], function () {
        // Accounts Index (Main Menu)...
        Route::get('/accounts', [AccountsController::class, 'index'])->name('accounts.index');

        // User Profile, Picture, Password...
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/delete', [ProfileController::class, 'delete'])->name('profile.delete');
        Route::post('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/profile/picture/edit', [ProfilePictureController::class, 'edit'])->name('profile.picture.edit');
        Route::put('/profile/picture', [ProfilePictureController::class, 'update'])->name('profile.picture.update');
        Route::delete('/profile/picture', [ProfilePictureController::class, 'destroy'])->name('profile.picture.destroy');
        Route::get('/profile/password/edit', [PasswordController::class, 'edit'])->name('profile.password.edit');
        Route::put('/profile/password', [PasswordController::class, 'update'])->name('profile.password.update');

        Route::group(['middleware' => 'verified'], function () {
            if (Hotstream::hasTeamFeatures()) {
                // Manage Teams...
                Route::get('/teams/create', [TeamsController::class, 'create'])->name('teams.create');
                Route::post('/teams', [TeamsController::class, 'store'])->name('teams.store');
                Route::get('/teams/{team}', [TeamsController::class, 'show'])->name('teams.show');
                Route::get('/teams/{team}/edit', [TeamsController::class, 'edit'])->name('teams.edit');
                Route::put('/teams/{team}', [TeamsController::class, 'update'])->name('teams.update');
                Route::get('/teams/{team}/delete', [TeamsController::class, 'delete'])->name('teams.delete');
                Route::delete('/teams/{team}', [TeamsController::class, 'destroy'])->name('teams.destroy');
                Route::put('/teams/{team}/current', [CurrentTeamsController::class, 'update'])->name('teams.current');

                // Team Members...
                Route::get('/teams/{team}/users', [TeamUsersController::class, 'index'])->name('team-users.index');
                Route::delete('/teams/{team}/users/{user}', [TeamUsersController::class, 'destroy'])->name('teams.team-users.destroy');
                Route::get('/teams/{team}/team-users/{user}/role/edit', [TeamUserRoleController::class, 'edit'])->name('teams.team-users.role.edit');
                Route::put('/teams/{team}/team-users/{user}/role', [TeamUserRoleController::class, 'update'])->name('teams.team-users.role.update');

                // Pending Invitations...
                Route::get('/teams/{team}/invitations', [TeamInvitationsController::class, 'index'])->name('team-invitations.index');
                Route::get('/teams/{team}/invitations/create', [TeamInvitationsController::class, 'create'])->name('team-invitations.create');
                Route::post('/teams/{team}/invitations', [TeamInvitationsController::class, 'store'])->name('team-invitations.store');
                Route::delete('/team-invitations/{invitation}', [TeamInvitationsController::class, 'destroy'])->name('team-invitations.destroy');

                // Accepting Invitation...
                Route::get('/team-invitations/{invitation}/accept', [AcceptedTeamInvitationsController::class, 'update'])->middleware('signed')->name('team-invitations.accept');
            }

            // Two Factor Authentication...
            Route::get('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'index'])->middleware('password.confirm')->name('two-factor-authentication.index');
            Route::delete('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])->middleware('password.confirm')->name('two-factor-authentication.destroy');
            Route::post('/enabled-two-factor-authentication', [EnabledTwoFactorAuthenticationController::class, 'store'])->middleware('password.confirm')->name('enabled-two-factor-authentication.store');
            Route::get('/confirmed-two-factor-authentication/create', [ConfirmedTwoFactorAuthenticationController::class, 'create'])->middleware('password.confirm')->name('confirmed-two-factor-authentication.create');
            Route::post('/confirmed-two-factor-authentication', [ConfirmedTwoFactorAuthenticationController::class, 'store'])->middleware('password.confirm')->name('confirmed-two-factor-authentication.store');
            Route::get('/recovery-codes', [RecoveryCodesController::class, 'index'])->middleware('password.confirm')->name('recovery-codes.index');
            Route::post('/recovery-codes', [RecoveryCodesController::class, 'store'])->middleware('password.confirm')->name('recovery-codes.store');

            // Devices & Sessions...
            Route::get('/device-sessions', [DeviceSessionsController::class, 'index'])->name('device-sessions.index');
            Route::get('/deleted-device-sessions', [DeletedDeviceSessionsController::class, 'edit'])->name('deleted-device-sessions.edit');
            Route::put('/deleted-device-sessions', [DeletedDeviceSessionsController::class, 'update'])->name('deleted-device-sessions.update');

            if (Hotstream::hasApiFeatures()) {
                // API Tokens...
                Route::get('/user/api-tokens', [UserApiTokensController::class, 'index'])->name('api-tokens.index');
                Route::get('/user/api-tokens/create', [UserApiTokensController::class, 'create'])->name('api-tokens.create');
                Route::post('/user/api-tokens', [UserApiTokensController::class, 'store'])->name('api-tokens.store');
                Route::get('/user/api-tokens/{token}', [UserApiTokensController::class, 'show'])->name('api-tokens.show');
                Route::delete('/user/api-tokens/{token}', [UserApiTokensController::class, 'destroy'])->name('api-tokens.destroy');
                Route::get('/user/api-tokens/{token}/edit', [UserApiTokensController::class, 'edit'])->name('api-tokens.edit');
                Route::put('/user/api-tokens/{token}', [UserApiTokensController::class, 'update'])->name('api-tokens.update');
            }
        });
    });
});
