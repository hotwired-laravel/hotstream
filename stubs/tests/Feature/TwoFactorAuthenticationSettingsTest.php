<?php

use App\Models\User;
use Laravel\Fortify\Features;

test('two factor authentication can be enabled', function () {
    $this->actingAs($user = User::factory()->create()->fresh())
        ->withSession(['auth.password_confirmed_at' => time()])
        ->post(route('enabled-two-factor-authentication.store'));

    $user = $user->fresh();

    expect($user->two_factor_secret)->not->toBeNull();
    expect($user->recoveryCodes())->toHaveCount(8);
})->skip(function () {
    return ! Features::canManageTwoFactorAuthentication();
}, 'Two factor authentication is not enabled.');

test('recovery codes can be regenerated', function () {
    $this->actingAs($user = User::factory()->create()->fresh())
        ->withSession(['auth.password_confirmed_at' => time()])
        ->post(route('enabled-two-factor-authentication.store'));

    $this->post(route('recovery-codes.store'));

    $user = $user->fresh();
    $previousRecoveryCodes = $user->recoveryCodes();

    $this->actingAs($user)->post(route('recovery-codes.store'));

    expect($user->refresh()->recoveryCodes())->toHaveCount(8);
    expect(array_diff($previousRecoveryCodes, $user->recoveryCodes()))->toHaveCount(8);
})->skip(function () {
    return ! Features::canManageTwoFactorAuthentication();
}, 'Two factor authentication is not enabled.');

test('two factor authentication can be disabled', function () {
    $this->actingAs($user = User::factory()->create()->fresh())
        ->withSession(['auth.password_confirmed_at' => time()])
        ->post(route('enabled-two-factor-authentication.store'));

    $this->assertNotNull($user->fresh()->two_factor_secret);

    $this->delete(route('two-factor-authentication.destroy'));

    expect($user->fresh()->two_factor_secret)->toBeNull();
})->skip(function () {
    return ! Features::canManageTwoFactorAuthentication();
}, 'Two factor authentication is not enabled.');
