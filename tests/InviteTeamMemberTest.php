<?php

use App\Actions\Hotstream\InviteTeamMember;
use App\Models\Team;
use HotwiringLaravel\Hotstream\Hotstream;
use HotwiringLaravel\Hotstream\Tests\Fixtures\TeamPolicy;
use HotwiringLaravel\Hotstream\Tests\Fixtures\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

beforeEach(function () {
    Gate::policy(Team::class, TeamPolicy::class);
    Hotstream::useUserModel(User::class);
    migrate();
});

test('team members can be invited', function () {
    Mail::fake();

    Hotstream::role('admin', 'Admin', ['foo']);

    $team = createTeam();

    $otherUser = User::forceCreate([
        'name' => 'Adam Wathan',
        'email' => 'adam@laravel.com',
        'password' => 'secret',
    ]);

    $action = new InviteTeamMember;

    $action->invite($team->owner, $team, 'adam@laravel.com', 'admin');

    $team = $team->fresh();

    $this->assertCount(0, $team->users);
    $this->assertCount(1, $team->teamInvitations);
    $this->assertEquals('adam@laravel.com', $team->teamInvitations->first()->email);
    $this->assertEquals($team->id, $team->teamInvitations->first()->team->id);
});

test('user cant already be on team', function () {
    Mail::fake();

    $this->expectException(ValidationException::class);

    $team = createTeam();

    $otherUser = User::forceCreate([
        'name' => 'Adam Wathan',
        'email' => 'adam@laravel.com',
        'password' => 'secret',
    ]);

    $action = new InviteTeamMember;

    $action->invite($team->owner, $team, 'adam@laravel.com', 'admin');
    $this->assertTrue(true);
    $action->invite($team->owner, $team->fresh(), 'adam@laravel.com', 'admin');
});
