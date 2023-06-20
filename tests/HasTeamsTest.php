<?php

use App\Models\Team;
use App\Models\User;
use HotwiringLaravel\Hotstream\Hotstream;
use HotwiringLaravel\Hotstream\OwnerRole;
use HotwiringLaravel\Hotstream\Role;
use HotwiringLaravel\Hotstream\Tests\Fixtures\User as UserFixture;

beforeEach(function () {
    Hotstream::$permissions = [];
    Hotstream::$roles = [];

    Hotstream::useUserModel(UserFixture::class);
});

test('teamRole retursn an OwnerRole for the team owner', function () {
    $team = Team::factory()->create();

    $this->assertInstanceOf(OwnerRole::class, $team->owner->teamRole($team));
});

test('teamRole returns the matching role', function () {
    Hotstream::role('admin', 'Admin', [
        'read',
        'create',
    ])->description('Admin Description');

    $team = Team::factory()
        ->hasAttached(User::factory(), [
            'role' => 'admin',
        ])
        ->create();
    $role = $team->users->first()->teamRole($team);

    $this->assertInstanceOf(Role::class, $role);
    $this->assertSame('admin', $role->key);
});

test('teamRole returns null if the user does not belong to the team', function () {
    $team = Team::factory()->create();

    $this->assertNull((new UserFixture())->teamRole($team));
});

test('teamRole returns null if the user does not have a role on the site', function () {
    $team = Team::factory()
        ->has(User::factory())
        ->create();

    $this->assertNull($team->users->first()->teamRole($team));
});

test('teamPermissions returns all for team owners', function () {
    $team = Team::factory()->create();

    $this->assertSame(['*'], $team->owner->teamPermissions($team));
});

test('teamPermissions returns empty for non members', function () {
    $team = Team::factory()->create();

    $this->assertSame([], (new UserFixture())->teamPermissions($team));
});

test('teamPermissions returns permissions for the users role', function () {
    Hotstream::role('admin', 'Admin', [
        'read',
        'create',
    ])->description('Admin Description');

    $team = Team::factory()
        ->hasAttached(User::factory(), [
            'role' => 'admin',
        ])
        ->create();

    $this->assertSame(['read', 'create'], $team->users->first()->teamPermissions($team));
});

test('teamPermissions returns empty permissions for members without a defined role', function () {
    Hotstream::role('admin', 'Admin', [
        'read',
        'create',
    ])->description('Admin Description');

    $team = Team::factory()
        ->has(User::factory())
        ->create();

    $this->assertSame([], $team->users->first()->teamPermissions($team));
});
