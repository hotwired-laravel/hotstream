<?php

use App\Models\User;
use HotwiredLaravel\Hotstream\Features;

test('validates token', function ($input, $errors) {
    if (Features::hasTeamFeatures()) {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    } else {
        $this->actingAs($user = User::factory()->create());
    }

    $this->from(route('api-tokens.index'))
        ->post(route('api-tokens.store'), $input)
        ->assertRedirect(route('api-tokens.index'))
        ->assertInvalid($errors);
})->with(fn () => [
    'required' => [
        'input' => $input = ['name' => null],
        'errors' => array_keys($input),
    ],
    'max length' => [
        'input' => $input = ['name' => str_repeat('a', 256)],
        'errors' => array_keys($input),
    ],
])->skip(function () {
    return ! Features::hasApiFeatures();
}, 'API support is not enabled.');

test('api tokens can be created', function () {
    if (Features::hasTeamFeatures()) {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    } else {
        $this->actingAs($user = User::factory()->create());
    }

    $this->post(route('api-tokens.store'), [
        'name' => 'Test Token',
        'permissions' => [
            'read',
            'update',
        ],
    ])->assertRedirect(route('api-tokens.index'));

    expect($user->fresh()->tokens)->toHaveCount(1);
    expect($user->fresh()->tokens->first())
        ->name->toEqual('Test Token')
        ->can('read')->toBeTrue()
        ->can('delete')->toBeFalse();
})->skip(function () {
    return ! Features::hasApiFeatures();
}, 'API support is not enabled.');
