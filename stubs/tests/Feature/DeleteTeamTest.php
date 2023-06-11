<?php

use App\Models\Team;
use App\Models\User;

test('teams can be deleted', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->ownedTeams()->save($team = Team::factory()->make([
        'personal_team' => false,
    ]));

    $team->users()->attach(
        $otherUser = User::factory()->create(),
        ['role' => 'test-role']
    );

    $this->delete(route('teams.destroy', $team))
        ->assertRedirect(route('dashboard'));

    expect($team->fresh())->toBeNull();
    expect($otherUser->fresh()->teams)->toHaveCount(0);
});

test('personal teams cant be deleted', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create())
        ->delete(route('teams.destroy', $user->currentTeam))
        ->assertInvalid(['team']);

    expect($user->currentTeam->fresh())->not->toBeNull();
});
