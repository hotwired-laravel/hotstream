<?php

use App\Actions\Hotstream\CreateTeam;
use App\Models\Team;
use HotwiredLaravel\Hotstream\Hotstream;
use HotwiredLaravel\Hotstream\Tests\Fixtures\TeamPolicy;
use HotwiredLaravel\Hotstream\Tests\Fixtures\User;
use HotwiredLaravel\Hotstream\Tests\Fixtures\WithTeamsFeature;
use Illuminate\Support\Facades\Gate;
use function Pest\Laravel\actingAs;

uses(WithTeamsFeature::class);

beforeEach(function () {
    Gate::policy(Team::class, TeamPolicy::class);
    Hotstream::useUserModel(User::class);
    migrate();
});

test('can switch to team the user belongs to', function () {
    $action = new CreateTeam;

    $user = User::forceCreate([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $team = $action->create($user, ['name' => 'Test Team']);

    actingAs($user)
        ->put("/teams/{$team->id}/current")
        ->assertRedirect('/home');

    $this->assertTrue($team->is($user->refresh()->currentTeam));
    $this->assertTrue($user->isCurrentTeam($team));
});

test('cannot switch to team the user does not belong to', function () {
    $action = new CreateTeam;

    $team = $action->create(User::forceCreate([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]), ['name' => 'Test Team']);

    $otherUser = User::forceCreate([
        'name' => 'Other User',
        'email' => 'other@example.com',
        'password' => 'password',
    ]);

    actingAs($otherUser)
        ->put("/teams/{$team->id}/current")
        ->assertForbidden();
});
