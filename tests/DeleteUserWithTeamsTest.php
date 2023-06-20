<?php

use App\Actions\Hotstream\DeleteTeam;
use App\Models\Team;
use HotwiringLaravel\Hotstream\Hotstream;
use HotwiringLaravel\Hotstream\Tests\Fixtures\TeamPolicy;
use HotwiringLaravel\Hotstream\Tests\Fixtures\User;
use HotwiringLaravel\Hotstream\Tests\Fixtures\WithTeamsFeature;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

uses(WithTeamsFeature::class);

beforeEach(function () {
    Gate::policy(Team::class, TeamPolicy::class);
    Hotstream::useUserModel(User::class);
    migrate();

    Schema::create('personal_access_tokens', function ($table) {
        $table->id();
        $table->foreignId('tokenable_id');
        $table->string('tokenable_type');
    });
});

test('can delete user', function () {
    $team = createTeam();
    $otherTeam = createTeam();

    $otherTeam->users()->attach($team->owner, ['role' => null]);

    $this->assertSame(2, DB::table('teams')->count());
    $this->assertSame(1, DB::table('team_user')->count());

    file_put_contents(
        $fixture = __DIR__.'/Fixtures/DeleteUser.php',
        str_replace('class DeleteUser', 'class DeleteUserWithTeams', file_get_contents(__DIR__.'/../stubs/app/Actions/Hotstream/DeleteUserWithTeams.php')),
    );

    require $fixture;

    $action = new \App\Actions\Hotstream\DeleteUserWithTeams(new DeleteTeam);

    $action->delete($team->owner);

    $this->assertNull($team->owner->fresh());
    $this->assertSame(1, DB::table('teams')->count());
    $this->assertSame(0, DB::table('team_user')->count());

    @unlink($fixture);
});
