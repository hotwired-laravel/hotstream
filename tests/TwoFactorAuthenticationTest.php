<?php

use Hotwired\Hotstream\Hotstream;
use Hotwired\Hotstream\Tests\Fixtures\User;
use Hotwired\Hotstream\Tests\Fixtures\WithFortifyFeatures;
use Illuminate\Auth\Middleware\RequirePassword;

use function Pest\Laravel\actingAs;

uses(WithFortifyFeatures::class);

beforeEach(function () {
    Hotstream::useUserModel(User::class);

    $this->withoutTailwind();
});

test('empty two factor state is noted', function () {
    $user = User::forceCreate([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'secret',
    ]);

    actingAs($user)
        ->withoutMiddleware(RequirePassword::class)
        ->get('/two-factor-authentication')
        ->assertOk()
        ->assertSee('You have not enabled two factor authentication.');
});

test('two factor enabled is noted', function () {
    $user = User::forceCreate([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'secret',
        'two_factor_secret' => 'test-secret',
        'two_factor_recovery_codes' => 'test-codes',
        'two_factor_confirmed_at' => now(),
    ]);

    actingAs($user)
        ->withoutMiddleware(RequirePassword::class)
        ->get('/two-factor-authentication')
        ->assertOk()
        ->assertSee('You have enabled two factor authentication.');
});
