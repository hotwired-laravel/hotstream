<?php

use App\Actions\Hotstream\AddTeamMember;
use App\Models\Team;
use Hotwired\Hotstream\Hotstream;
use Hotwired\Hotstream\Models\Membership;
use Hotwired\Hotstream\Tests\Fixtures\TeamPolicy;
use Hotwired\Hotstream\Tests\Fixtures\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\TransientToken;

beforeEach(function () {
    Gate::policy(Team::class, TeamPolicy::class);

    Hotstream::useUserModel(User::class);
});

test('team members can be added', function () {
    Hotstream::role('admin', 'Admin', ['foo']);

    migrate();

    $team = createTeam();

    $otherUser = User::forceCreate([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $action = new AddTeamMember();

    $action->add($team->owner, $team, 'test@example.com', 'admin');

    $this->assertCount(1, $team->refresh()->users);

    $this->assertInstanceOf(Membership::class, $team->users->first()->membership);

    $this->assertTrue($otherUser->hasTeamRole($team, 'admin'));
    $this->assertFalse($otherUser->hasTeamRole($team, 'editor'));
    $this->assertFalse($otherUser->hasTeamRole($team, 'foobar'));

    $team->users->first()->withAccessToken(new TransientToken);

    $this->assertTrue($team->users->first()->hasTeamPermission($team, 'foo'));
    $this->assertFalse($team->users->first()->hasTeamPermission($team, 'bar'));
});

test('user email address must exist', function () {
    $this->expectException(ValidationException::class);

    migrate();

    $team = createTeam();

    $action = new AddTeamMember;

    $action->add($team->owner, $team, 'missing@laravel.com', 'admin');

    $this->assertCount(1, $team->fresh()->users);
});

test('user cant already be on team', function () {
    $this->expectException(ValidationException::class);

    migrate();

    $team = createTeam();

    User::forceCreate([
        'name' => 'Adam Wathan',
        'email' => 'adam@laravel.com',
        'password' => 'secret',
    ]);

    $action = new AddTeamMember;

    $action->add($team->owner, $team, 'adam@laravel.com', 'admin');

    $this->assertTrue(true);

    $action->add($team->owner, $team->fresh(), 'adam@laravel.com', 'admin');
});
