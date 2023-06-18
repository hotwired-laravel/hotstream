<?php

use App\Actions\Hotstream\CreateTeam;
use App\Actions\Hotstream\UpdateTeamName;
use App\Models\Team;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Hotwired\Hotstream\Hotstream;
use Hotwired\Hotstream\Tests\Fixtures\TeamPolicy;
use Hotwired\Hotstream\Tests\Fixtures\User;
use Hotwired\Hotstream\Tests\Fixtures\WithTeamsFeature;

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
