<?php

use App\Actions\Hotstream\UpdateTeamName;
use App\Models\Team;
use HotwiredLaravel\Hotstream\Hotstream;
use HotwiredLaravel\Hotstream\Tests\Fixtures\TeamPolicy;
use HotwiredLaravel\Hotstream\Tests\Fixtures\User;
use HotwiredLaravel\Hotstream\Tests\Fixtures\WithTeamsFeature;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

uses(WithTeamsFeature::class);

beforeEach(function () {
    Gate::policy(Team::class, TeamPolicy::class);
    Hotstream::useUserModel(User::class);
    migrate();
});

test('team name can be updated', function () {
    $team = createTeam();

    $action = new UpdateTeamName;

    $action->update($team->owner, $team, ['name' => 'Test Team Updated']);

    $this->assertSame('Test Team Updated', $team->fresh()->name);
});

test('name is required', function () {
    $this->expectException(ValidationException::class);

    $team = createTeam();

    $action = new UpdateTeamName;

    $action->update($team->owner, $team, ['name' => '']);
});
