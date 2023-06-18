<?php

use App\Actions\Hotstream\RemoveTeamMember;
use App\Models\Team;
use Hotwired\Hotstream\Events\RemovingTeamMember;
use Hotwired\Hotstream\Events\TeamMemberRemoved;
use Hotwired\Hotstream\Hotstream;
use Hotwired\Hotstream\Tests\Fixtures\TeamPolicy;
use Hotwired\Hotstream\Tests\Fixtures\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

beforeEach(function () {
    Gate::policy(Team::class, TeamPolicy::class);
    Hotstream::useUserModel(User::class);
    migrate();
});

test('team members can be removed', function () {
    Event::fake([TeamMemberRemoved::class]);

    $team = createTeam();

    $otherUser = User::forceCreate([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $team->users()->attach($otherUser, ['role' => null]);

    $this->assertCount(1, $team->fresh()->users);

    Auth::login($team->owner);

    $action = new RemoveTeamMember;

    $action->remove($team->owner, $team, $otherUser);

    $this->assertCount(0, $team->fresh()->users);

    Event::assertDispatched(TeamMemberRemoved::class);
});

test('a team owner cant remove themselves', function () {
    $this->expectException(ValidationException::class);

    Event::fake([RemovingTeamMember::class]);

    $team = createTeam();

    Auth::login($team->owner);

    $action = new RemoveTeamMember;

    $action->remove($team->owner, $team, $team->owner);
});

test('the user must be authorized to remove team members', function () {
    $this->expectException(AuthorizationException::class);

    $team = createTeam();

    $adam = User::forceCreate([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'secret',
    ]);

    $abigail = User::forceCreate([
        'name' => 'Another User',
        'email' => 'another@example.com',
        'password' => 'secret',
    ]);

    $team->users()->attach($adam, ['role' => null]);
    $team->users()->attach($abigail, ['role' => null]);

    Auth::login($team->owner);

    $action = new RemoveTeamMember;

    $action->remove($adam, $team, $abigail);
});
