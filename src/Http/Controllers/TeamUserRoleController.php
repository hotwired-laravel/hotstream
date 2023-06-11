<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Hotwired\Hotstream\Actions\UpdateTeamMemberRole;
use Hotwired\Hotstream\Hotstream;
use Hotwired\Hotstream\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TeamUserRoleController
{
    public function edit($teamId, $userId)
    {
        $team = Hotstream::newTeamModel()->findOrFail($teamId);
        $user = $team->users()->findOrFail($userId);

        if (Gate::denies('updateTeamMember', $team)) {
            abort(403);
        }

        return view('team-user-role.edit', [
            'team' => $team,
            'user' => $user,
            'roles' => collect(Hotstream::$roles)->transform(function ($role) {
                return with($role->jsonSerialize(), function ($data) {
                    return (new Role(
                        $data['key'],
                        $data['name'],
                        $data['permissions']
                    ))->description($data['description']);
                });
            })->values()->all(),
        ]);
    }

    public function update(Request $request, UpdateTeamMemberRole $updater, $teamId, $userId)
    {
        $team = Hotstream::newTeamModel()->findOrFail($teamId);

        if (Gate::denies('updateTeamMember', $team)) {
            abort(403);
        }

        $updater->update($request->user(), $team, $userId, $request->input('role'));

        return redirect()->route('team-users.index', $team)->with('status', __('Member role updated.'));
    }
}
