<?php

use App\Models\User;

test('validates team', function ($input, $errors) {
    $this->actingAs(User::factory()->withPersonalTeam()->create())
        ->from(route('teams.create'))
        ->post(route('teams.store'), $input)
        ->assertRedirect(route('teams.create'))
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
]);

test('teams can be created', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create())
        ->from(route('teams.create'))
        ->post(route('teams.store'), ['name' => 'Test Team'])
        ->assertRedirect(route('dashboard'));

    expect($user->fresh()->ownedTeams)->toHaveCount(2);
    expect($user->fresh()->ownedTeams()->latest('id')->first()->name)->toEqual('Test Team');
});
