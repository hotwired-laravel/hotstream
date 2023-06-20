<?php

use App\Models\User;
use HotwiredLaravel\Hotstream\Features;
use HotwiredLaravel\Hotstream\Mail\TeamInvitation;
use Illuminate\Support\Facades\Mail;

test('validations team member invitation', function ($input, $errors) {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create())
        ->post(route('team-invitations.store', $user->currentTeam), $input)
        ->assertInvalid($errors);
})->with(fn () => [
    'required' => [
        'input' => $input = ['email' => null, 'role' => null],
        'errors' => array_keys($input),
    ],
    'email must be valid' => [
        'input' => $input = ['email' => 'invalidemail'],
        'errors' => array_keys($input),
    ],
]);

test('team members can be invited to team', function () {
    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create())
        ->post(route('team-invitations.store', $user->currentTeam), [
            'email' => 'test@example.com',
            'role' => 'admin',
        ])
        ->assertValid()
        ->assertRedirect(route('team-invitations.index', $user->currentTeam));

    Mail::assertSent(TeamInvitation::class);

    expect($user->currentTeam->fresh()->teamInvitations)->toHaveCount(1);
})->skip(function () {
    return ! Features::sendsTeamInvitations();
}, 'Team invitations not enabled.');

test('team member invitations can be cancelled', function () {
    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    // Add the team member...
    $this->actingAs($user = User::factory()->withPersonalTeam()->create())
        ->post(route('team-invitations.store', $user->currentTeam), [
            'email' => 'test@example.com',
            'role' => 'admin',
        ])
        ->assertValid();

    $invitationId = $user->currentTeam->fresh()->teamInvitations->first()->id;

    // Cancel the team invitation...
    $this->actingAs($user)
        ->delete(route('team-invitations.destroy', $invitationId));

    expect($user->currentTeam->fresh()->teamInvitations)->toHaveCount(0);
})->skip(function () {
    return ! Features::sendsTeamInvitations();
}, 'Team invitations not enabled.');
