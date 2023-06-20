<?php

namespace App\Actions\Hotstream;

use App\Models\Team;
use App\Models\User;
use HotwiredLaravel\Hotstream\Contracts\CreatesTeams;
use HotwiredLaravel\Hotstream\Events\AddingTeam;
use HotwiredLaravel\Hotstream\Hotstream;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CreateTeam implements CreatesTeams
{
    /**
     * Validate and create a new team for the given user.
     */
    public function create(User $user, array $input): Team
    {
        Gate::forUser($user)->authorize('create', Hotstream::newTeamModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        AddingTeam::dispatch($user);

        $user->switchTeam($team = $user->ownedTeams()->create([
            'name' => $input['name'],
            'personal_team' => false,
        ]));

        return $team;
    }
}
