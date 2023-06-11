<?php

use App\Models\User;

test('validates update team name', function ($input, $errors) {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create())
        ->put(route('teams.update', $user->currentTeam), $input)
        ->assertInvalid($errors);
})->with(fn () => [
    'required' => [
        'input' => $input = ['name' => null],
        'errors' => array_keys($input),
    ],
]);

test('team names can be updated', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create())
        ->put(route('teams.update', $user->currentTeam), [
            'name' => 'Test Team',
        ])
        ->assertValid();

    expect($user->fresh()->ownedTeams)->toHaveCount(1);
    expect($user->currentTeam->fresh()->name)->toEqual('Test Team');
});
