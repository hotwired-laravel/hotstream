<?php

use App\Models\User;

test('team members can be removed from teams', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(),
        ['role' => 'admin']
    );

    $this->delete(route('teams.team-users.destroy', [$user->currentTeam, $otherUser]))
        ->assertValid();

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
});

test('only team owner can remove team members', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(),
        ['role' => 'admin']
    );

    $this->actingAs($otherUser)
        ->delete(route('teams.team-users.destroy', [$user->currentTeam, $user]))
        ->assertForbidden();
});
