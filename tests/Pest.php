<?php

use App\Actions\Hotstream\CreateTeam;
use App\Models\Team;
use Hotwired\Hotstream\Tests\Fixtures\User;
use Hotwired\Hotstream\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

uses(TestCase::class)->in(__DIR__);

function createTeam(array $overrides = []): Team
{
    $action = new CreateTeam;

    $user = User::forceCreate(array_replace([
        'name' => 'Tony Messias',
        'email' => 'tonysm@example.com',
        'password' => 'password',
    ], $overrides));

    return $action->create($user, ['name' => 'Test Team']);
}

function migrate(): void
{
    Artisan::call('migrate');
}
