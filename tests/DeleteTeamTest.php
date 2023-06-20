<?php

use App\Actions\Hotstream\DeleteTeam;
use HotwiringLaravel\Hotstream\Actions\ValidateTeamDeletion;
use HotwiringLaravel\Hotstream\Hotstream;
use HotwiringLaravel\Hotstream\Models\Team;
use HotwiringLaravel\Hotstream\Tests\Fixtures\TeamPolicy;
use HotwiringLaravel\Hotstream\Tests\Fixtures\User;
use HotwiringLaravel\Hotstream\Tests\Fixtures\WithTeamsFeature;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

uses(WithTeamsFeature::class);

beforeEach(function () {
    Gate::policy(Team::class, TeamPolicy::class);
    Hotstream::useUserModel(User::class);
    migrate();
});

test('team can be deleted', function () {
    $team = createTeam();

    $action = new DeleteTeam;

    $action->delete($team);

    $this->assertNull($team->fresh());
});

test('validates team deletion', function () {
    Hotstream::useUserModel(User::class);

    $team = createTeam();

    $action = new ValidateTeamDeletion;

    $action->validate($team->owner, $team);

    $this->assertTrue(true);
});

test('cannot delete personal team', function () {
    $this->expectException(ValidationException::class);

    Hotstream::useUserModel(User::class);

    $team = createTeam();

    $team->forceFill(['personal_team' => true])->save();

    $action = new ValidateTeamDeletion;

    $action->validate($team->owner, $team);
});

test('non-owner cannot delete team', function () {
    $this->expectException(AuthorizationException::class);

    Hotstream::useUserModel(User::class);

    $team = createTeam();

    $action = new ValidateTeamDeletion;

    $action->validate(User::forceCreate([
        'name' => 'Adam Wathan',
        'email' => 'adam@laravel.com',
        'password' => 'secret',
    ]), $team);
});
