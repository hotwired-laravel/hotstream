<?php

use App\Actions\Hotstream\CreateTeam;
use App\Models\Team;
use HotwiredLaravel\Hotstream\Hotstream;
use HotwiredLaravel\Hotstream\Tests\Fixtures\TeamPolicy;
use HotwiredLaravel\Hotstream\Tests\Fixtures\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

beforeEach(function () {
    Gate::policy(Team::class, TeamPolicy::class);
    Hotstream::useUserModel(User::class);
    migrate();
});

test('can create team', function () {
    $action = new CreateTeam;

    $user = User::forceCreate([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $team = $action->create($user, ['name' => 'Test Team']);

    $this->assertInstanceOf(Team::class, $team);
});

test('name is required', function () {
    $this->expectException(ValidationException::class);

    $action = new CreateTeam;

    $user = User::forceCreate([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $action->create($user, ['name' => '']);
});
