<?php

use Hotwired\Hotstream\Hotstream;
use Hotwired\Hotstream\Http\Controllers\AcceptedTeamInvitationsController;
use Hotwired\Hotstream\Http\Controllers\AccountsController;
use Hotwired\Hotstream\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Hotwired\Hotstream\Http\Controllers\CurrentTeamsController;
use Hotwired\Hotstream\Http\Controllers\DeletedDeviceSessionsController;
use Hotwired\Hotstream\Http\Controllers\DeviceSessionsController;
use Hotwired\Hotstream\Http\Controllers\EnabledTwoFactorAuthenticationController;
use Hotwired\Hotstream\Http\Controllers\PasswordController;
use Hotwired\Hotstream\Http\Controllers\PrivacyPolicyController;
use Hotwired\Hotstream\Http\Controllers\RecoveryCodesController;
use Hotwired\Hotstream\Http\Controllers\TeamInvitationsController;
use Hotwired\Hotstream\Http\Controllers\TeamsController;
use Hotwired\Hotstream\Http\Controllers\TeamUserRoleController;
use Hotwired\Hotstream\Http\Controllers\TeamUsersController;
use Hotwired\Hotstream\Http\Controllers\TermsOfServiceController;
use Hotwired\Hotstream\Http\Controllers\TwoFactorAuthenticationController;
use Hotwired\Hotstream\Http\Controllers\UserApiTokensController;
use Hotwired\Hotstream\Http\Controllers\UserController;
use Hotwired\Hotstream\Http\Controllers\UserPictureController;
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
        Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user', [UserController::class, 'update'])->name('user.update');
        Route::get('/user/delete', [UserController::class, 'delete'])->name('user.delete');
        Route::post('/user/delete', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/user/picture/edit', [UserPictureController::class, 'edit'])->name('user.picture.edit');
        Route::put('/user/picture', [UserPictureController::class, 'update'])->name('user.picture.update');
        Route::delete('/user/picture', [UserPictureController::class, 'destroy'])->name('user.picture.destroy');
        Route::get('/user/password/edit', [PasswordController::class, 'edit'])->name('user.password.edit');
        Route::put('/user/password', [PasswordController::class, 'update'])->name('user.password.update');

        Route::group(['middleware' => 'verified'], function () {
            // Manage Teams...
            Route::get('/teams/create', [TeamsController::class, 'create'])->name('teams.create');
            Route::post('/teams', [TeamsController::class, 'store'])->name('teams.store');
            Route::get('/teams/{team}', [TeamsController::class, 'show'])->name('teams.show');
            Route::get('/teams/{team}/edit', [TeamsController::class, 'edit'])->name('teams.edit');
            Route::put('/teams/{team}', [TeamsController::class, 'update'])->name('teams.update');
            Route::get('/teams/{team}/delete', [TeamsController::class, 'delete'])->name('teams.delete');
            Route::delete('/teams/{team}', [TeamsController::class, 'destroy'])->name('teams.destroy');
            Route::put('/teams/{team}/current', [CurrentTeamsController::class, 'update'])->name('teams.current');

            // Two Factor Authentication...
            Route::get('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'index'])->middleware('password.confirm')->name('two-factor-authentication.index');
            Route::delete('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])->middleware('password.confirm')->name('two-factor-authentication.destroy');
            Route::post('/enabled-two-factor-authentication', [EnabledTwoFactorAuthenticationController::class, 'store'])->middleware('password.confirm')->name('enabled-two-factor-authentication.store');
            Route::get('/confirmed-two-factor-authentication/create', [ConfirmedTwoFactorAuthenticationController::class, 'create'])->middleware('password.confirm')->name('confirmed-two-factor-authentication.create');
            Route::post('/confirmed-two-factor-authentication', [ConfirmedTwoFactorAuthenticationController::class, 'store'])->middleware('password.confirm')->name('confirmed-two-factor-authentication.store');
            Route::get('/recovery-codes', [RecoveryCodesController::class, 'index'])->middleware('password.confirm')->name('recovery-codes.index');
            Route::post('/recovery-codes', [RecoveryCodesController::class, 'store'])->middleware('password.confirm')->name('recovery-codes.store');

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

            // Devices & Sessions...
            Route::get('/device-sessions', [DeviceSessionsController::class, 'index'])->name('device-sessions.index');
            Route::get('/deleted-device-sessions', [DeletedDeviceSessionsController::class, 'edit'])->name('deleted-device-sessions.edit');
            Route::put('/deleted-device-sessions', [DeletedDeviceSessionsController::class, 'update'])->name('deleted-device-sessions.update');

            // API Tokens...
            if (Hotstream::hasApiFeatures()) {
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
