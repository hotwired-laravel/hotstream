<?php

namespace HotwiringLaravel\Hotstream\Actions;

use HotwiringLaravel\Hotstream\Events\TeamMemberUpdated;
use HotwiringLaravel\Hotstream\Hotstream;
use HotwiringLaravel\Hotstream\Rules\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class UpdateTeamMemberRole
{
    /**
     * Update the role for the given team member.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  int  $teamMemberId
     * @return void
     */
    public function update($user, $team, $teamMemberId, string $role)
    {
        Gate::forUser($user)->authorize('updateTeamMember', $team);

        Validator::make([
            'role' => $role,
        ], [
            'role' => ['required', 'string', new Role],
        ])->validate();

        $team->users()->updateExistingPivot($teamMemberId, [
            'role' => $role,
        ]);

        TeamMemberUpdated::dispatch($team->fresh(), Hotstream::findUserByIdOrFail($teamMemberId));
    }
}
