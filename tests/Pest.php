<?php

use App\Actions\Hotstream\CreateTeam;
use App\Models\Team;
use HotwiringLaravel\Hotstream\Tests\Fixtures\User;
use HotwiringLaravel\Hotstream\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

uses(TestCase::class)->in(__DIR__);

function createTeam(array $team = [], array $user = []): Team
{
    $action = new CreateTeam;

    $user = User::forceCreate(array_replace([
        'name' => 'Tony Messias',
        'email' => fake()->unique()->email(),
        'password' => 'password',
    ], $user));

    return $action->create($user, array_replace(['name' => 'Test Team'], $team));
}

function migrate(): void
{
    Artisan::call('migrate');
}
