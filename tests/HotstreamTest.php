<?php

use HotwiredLaravel\Hotstream\Hotstream;
use HotwiredLaravel\Hotstream\Tests\Fixtures;

test('roles can be registered', function () {
    Hotstream::$permissions = [];
    Hotstream::$roles = [];

    Hotstream::role('admin', 'Admin', [
        'read',
        'create',
    ])->description('Admin Description');

    Hotstream::role('editor', 'Editor', [
        'read',
        'update',
        'delete',
    ])->description('Editor Description');

    $this->assertTrue(Hotstream::hasPermissions());

    $this->assertEquals([
        'create',
        'delete',
        'read',
        'update',
    ], Hotstream::$permissions);
});

test('roles can be json serialized', function () {
    Hotstream::$permissions = [];
    Hotstream::$roles = [];

    $role = Hotstream::role('admin', 'Admin', [
        'read',
        'create',
    ])->description('Admin Description');

    $serialized = $role->jsonSerialize();

    $this->assertArrayHasKey('key', $serialized);
    $this->assertArrayHasKey('name', $serialized);
    $this->assertArrayHasKey('description', $serialized);
    $this->assertArrayHasKey('permissions', $serialized);
});

test('has team feature will always return false when team is not enabled', function () {
    $this->assertFalse(Hotstream::hasTeamFeatures());
    $this->assertFalse(Hotstream::userHasTeamFeatures(new Fixtures\User));
    $this->assertFalse(Hotstream::userHasTeamFeatures(new Fixtures\Admin));
});
