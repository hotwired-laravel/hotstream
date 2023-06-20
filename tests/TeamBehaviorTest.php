<?php

use App\Actions\Hotstream\CreateTeam;
use HotwiringLaravel\Hotstream\Hotstream;
use HotwiringLaravel\Hotstream\Models\Team;
use HotwiringLaravel\Hotstream\Tests\Fixtures\TeamPolicy;
use HotwiringLaravel\Hotstream\Tests\Fixtures\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\TransientToken;

beforeEach(function () {
    Gate::policy(\App\Models\Team::class, TeamPolicy::class);
    Hotstream::useUserModel(User::class);
    migrate();
});

test('team relationship methods', function () {
    $action = new CreateTeam;

    $user = User::forceCreate([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'secret',
    ]);

    $team = $action->create($user, ['name' => 'Test Team']);

    $this->assertInstanceOf(Team::class, $team);

    $this->assertTrue($user->belongsToTeam($team));
    $this->assertTrue($user->ownsTeam($team));
    $this->assertCount(1, $user->fresh()->ownedTeams);
    $this->assertCount(1, $user->fresh()->allTeams());

    $team->forceFill(['personal_team' => true])->save();

    $this->assertEquals($team->id, $user->fresh()->personalTeam()->id);
    $this->assertEquals($team->id, $user->fresh()->currentTeam->id);
    $this->assertTrue($user->hasTeamPermission($team, 'foo'));

    // Test with another user that isn't on the team...
    $otherUser = User::forceCreate([
        'name' => 'Another User',
        'email' => 'another@example.com',
        'password' => 'secret',
    ]);

    $this->assertFalse($otherUser->belongsToTeam($team));
    $this->assertFalse($otherUser->ownsTeam($team));
    $this->assertFalse($otherUser->hasTeamPermission($team, 'foo'));

    // Add the other user to the team...
    Hotstream::role('editor', 'Editor', ['foo']);

    $otherUser->teams()->attach($team, ['role' => 'editor']);
    $otherUser = $otherUser->fresh();

    $this->assertTrue($otherUser->belongsToTeam($team));
    $this->assertFalse($otherUser->ownsTeam($team));

    $this->assertTrue($otherUser->hasTeamPermission($team, 'foo'));
    $this->assertFalse($otherUser->hasTeamPermission($team, 'bar'));

    $this->assertTrue($team->userHasPermission($otherUser, 'foo'));
    $this->assertFalse($team->userHasPermission($otherUser, 'bar'));

    $otherUser->withAccessToken(new TransientToken);

    $this->assertTrue($otherUser->belongsToTeam($team));
    $this->assertFalse($otherUser->ownsTeam($team));

    $this->assertTrue($otherUser->hasTeamPermission($team, 'foo'));
    $this->assertFalse($otherUser->hasTeamPermission($team, 'bar'));

    $this->assertTrue($team->userHasPermission($otherUser, 'foo'));
    $this->assertFalse($team->userHasPermission($otherUser, 'bar'));
});

test('has team permission checks token permissions', function () {
    Hotstream::role('admin', 'Administrator', ['foo']);

    $action = new CreateTeam;

    $user = User::forceCreate([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'secret',
    ]);

    $team = $action->create($user, ['name' => 'Test Team']);

    $anotherUser = User::forceCreate([
        'name' => 'Another User',
        'email' => 'another@example.com',
        'password' => 'secret',
    ]);

    $authToken = new Sanctum;
    $anotherUser = $authToken->actingAs($anotherUser, ['bar'], []);

    $team->users()->attach($anotherUser, ['role' => 'admin']);

    $this->assertFalse($anotherUser->hasTeamPermission($team, 'foo'));

    $john = User::forceCreate([
        'name' => 'John Doe',
        'email' => 'john@doe.com',
        'password' => 'secret',
    ]);

    $authToken = new Sanctum;
    $john = $authToken->actingAs($john, ['foo'], []);

    $team->users()->attach($john, ['role' => 'admin']);

    $this->assertTrue($john->hasTeamPermission($team, 'foo'));
});

test('user does not need to refresh after switching teams', function () {
    $action = new CreateTeam;

    $user = User::forceCreate([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'secret',
    ]);

    $personalTeam = $action->create($user, ['name' => 'Personal Team']);

    $personalTeam->forceFill(['personal_team' => true])->save();

    $this->assertTrue($user->isCurrentTeam($personalTeam));

    $anotherTeam = $action->create($user, ['name' => 'Test Team']);

    $this->assertTrue($user->isCurrentTeam($anotherTeam));
});
