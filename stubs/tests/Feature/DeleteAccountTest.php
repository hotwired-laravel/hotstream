<?php

use App\Models\User;
use HotwiredLaravel\Hotstream\Features;

test('user accounts can be deleted', function () {
    $this->actingAs($user = User::factory()->create())
        ->post(route('user.destroy'), [
            'password' => 'password',
        ])
        ->assertValid();

    expect($user->fresh())->toBeNull();
})->skip(function () {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');

test('correct password must be provided before account can be deleted', function () {
    $this->actingAs($user = User::factory()->create())
        ->post(route('user.destroy'), [
            'password' => 'wrong-password',
        ])
        ->assertInvalid('password');

    expect($user->fresh())->not->toBeNull();
})->skip(function () {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');
