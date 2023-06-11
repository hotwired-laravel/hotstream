<?php

use App\Models\User;

test('profile information can be updated', function () {
    $this->actingAs($user = User::factory()->create())
        ->put(route('user.update'), ['name' => 'Test Name', 'email' => 'test@example.com'])
        ->assertValid();

    expect($user->fresh())
        ->name->toEqual('Test Name')
        ->email->toEqual('test@example.com');
});
