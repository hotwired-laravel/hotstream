<?php

use App\Models\User;

test('users can leave teams', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(),
        ['role' => 'admin']
    );

    $this->actingAs($otherUser)
        ->delete(route('teams.team-users.destroy', [$user->currentTeam, $otherUser]));

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
});

test('team owners cant leave their own team', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create())
        ->delete(route('teams.team-users.destroy', [$user->currentTeam, $user]))
        ->assertInvalid('team');

    expect($user->currentTeam->fresh())->not->toBeNull();
});
