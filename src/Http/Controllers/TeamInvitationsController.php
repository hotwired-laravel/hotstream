<?php

namespace HotwiringLaravel\Hotstream\Http\Controllers;

use HotwiringLaravel\Hotstream\Contracts\InvitesTeamMembers;
use HotwiringLaravel\Hotstream\Hotstream;
use HotwiringLaravel\Hotstream\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TeamInvitationsController
{
    public function index($teamId)
    {
        $team = Hotstream::newTeamModel()->findOrFail($teamId);

        if (Gate::denies('view', $team)) {
            abort(403);
        }

        return view('team-invitations.index', [
            'team' => $team,
            'invitations' => $team->invitations,
        ]);
    }

    public function create($teamId)
    {
        $team = Hotstream::newTeamModel()->findOrFail($teamId);

        if (Gate::denies('view', $team)) {
            abort(403);
        }

        return view('team-invitations.create', [
            'team' => $team,
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

    public function store(Request $request, InvitesTeamMembers $invites, $teamId)
    {
        $team = Hotstream::newTeamModel()->findOrFail($teamId);

        $invites->invite($request->user(), $team, $request->string('email'), $request->string('role'));

        return ($request->input('redirect_to') === 'members'
            ? redirect()->route('team-users.index', $team)
            : redirect()->route('team-invitations.index', $team))->with('status', __('Invitation sent.'));
    }

    public function destroy($invitationId)
    {
        $invitation = Hotstream::newTeamInvitationModel()->findOrFail($invitationId);

        if (Gate::denies('removeTeamMember', $invitation->team)) {
            abort(403);
        }

        $invitation->delete();

        return redirect()->route('team-invitations.index', $invitation->team)->with('status', __('Invitation removed.'));
    }
}
