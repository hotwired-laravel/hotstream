<?php

namespace App\Actions\Hotstream;

use App\Models\Team;
use App\Models\User;
use HotwiredLaravel\Hotstream\Contracts\UpdatesTeamNames;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class UpdateTeamName implements UpdatesTeamNames
{
    /**
     * Validate and update the given team's name.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, Team $team, array $input): void
    {
        Gate::forUser($user)->authorize('update', $team);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validate();

        $team->forceFill([
            'name' => $input['name'],
        ])->save();
    }
}
