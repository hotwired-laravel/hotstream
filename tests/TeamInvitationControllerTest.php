<?php

use App\Models\Team;
use HotwiringLaravel\Hotstream\Contracts\AddsTeamMembers;
use HotwiringLaravel\Hotstream\Hotstream;
use HotwiringLaravel\Hotstream\Tests\Fixtures\TeamPolicy;
use HotwiringLaravel\Hotstream\Tests\Fixtures\User;
use HotwiringLaravel\Hotstream\Tests\Fixtures\WithTeamsFeature;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use function Pest\Laravel\actingAs;

uses(WithTeamsFeature::class);

beforeEach(function () {
    Gate::policy(Team::class, TeamPolicy::class);
    Hotstream::useUserModel(User::class);
    migrate();
});

test('team invitations can be accepted', function () {
    $this->mock(AddsTeamMembers::class)->shouldReceive('add')->once();

    Hotstream::role('admin', 'Admin', ['foo', 'bar']);
    Hotstream::role('editor', 'Editor', ['baz', 'qux']);

    $team = createTeam();

    $invitation = $team->teamInvitations()->create(['email' => 'user@example.com', 'role' => 'admin']);

    $url = URL::signedRoute('team-invitations.accept', ['invitation' => $invitation]);

    actingAs($team->owner)
        ->get($url)
        ->assertRedirect();
});
