<?php

use App\Models\Team;
use HotwiringLaravel\Hotstream\Hotstream;
use HotwiringLaravel\Hotstream\Tests\Fixtures\TeamPolicy;
use HotwiringLaravel\Hotstream\Tests\Fixtures\User;
use HotwiringLaravel\Hotstream\Tests\Fixtures\WithTeamsFeature;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\TransientToken;
use function Pest\Laravel\actingAs;

uses(WithTeamsFeature::class);

beforeEach(function () {
    Gate::policy(Team::class, TeamPolicy::class);
    Hotstream::useUserModel(User::class);
    migrate();
});

test('team member permissions can be updated', function () {
    Hotstream::role('admin', 'Admin', ['foo', 'bar']);
    Hotstream::role('editor', 'Editor', ['baz', 'qux']);

    $team = createTeam();

    $user = User::forceCreate([
        'name' => 'Adam Wathan',
        'email' => 'adam@laravel.com',
        'password' => 'secret',
    ]);

    $team->users()->attach($user, ['role' => 'admin']);

    actingAs($team->owner)
        ->put("/teams/{$team->id}/team-users/{$user->id}/role", [
            'role' => 'editor',
        ])
        ->assertRedirect();

    $user->refresh()->withAccessToken(new TransientToken);

    $this->assertTrue($user->hasTeamPermission($team, 'baz'));
    $this->assertTrue($user->hasTeamPermission($team, 'qux'));
});

test('team member permissions cant be updated if not authorized', function () {
    $team = createTeam();

    $user = User::forceCreate([
        'name' => 'Test User',
        'email' => 'user@example.com',
        'password' => 'secret',
    ]);

    $team->users()->attach($user, ['role' => 'admin']);

    actingAs($user)->put("/teams/{$team->id}/team-users/{$user->id}/role", [
        'role' => 'admin',
    ])->assertForbidden();
});
