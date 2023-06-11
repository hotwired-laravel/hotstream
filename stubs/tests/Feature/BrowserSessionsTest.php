<?php

use App\Models\User;

test('must provide matching password', function () {
    $this->actingAs(User::factory()->create())
        ->from(route('deleted-device-sessions.edit'))
        ->put(route('deleted-device-sessions.update'), [
            'password' => 'invalid',
        ])
        ->assertRedirect(route('deleted-device-sessions.edit'))
        ->assertInvalid('password');
});

test('other browser sessions can be logged out', function () {
    $this->actingAs(User::factory()->create())
        ->put(route('deleted-device-sessions.update'), [
            'password' => 'password',
        ])
        ->assertRedirect(route('device-sessions.index'));
});
