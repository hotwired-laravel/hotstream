<?php

use App\Models\User;
use HotwiringLaravel\Hotstream\Features;
use Illuminate\Support\Str;

test('api token permissions can be updated', function () {
    if (Features::hasTeamFeatures()) {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    } else {
        $this->actingAs($user = User::factory()->create());
    }

    $token = $user->tokens()->create([
        'name' => 'Test Token',
        'token' => Str::random(40),
        'abilities' => ['create', 'read'],
    ]);

    $this->actingAs($user)
        ->put(route('api-tokens.update', $token), [
            'permissions' => [
                'delete',
                'missing-permission',
            ],
        ]);

    expect($user->fresh()->tokens->first())
        ->can('delete')->toBeTrue()
        ->can('read')->toBeFalse()
        ->can('missing-permission')->toBeFalse();
})->skip(function () {
    return ! Features::hasApiFeatures();
}, 'API support is not enabled.');
