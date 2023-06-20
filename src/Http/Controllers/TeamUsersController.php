<?php

namespace HotwiredLaravel\Hotstream\Http\Controllers;

use HotwiredLaravel\Hotstream\Contracts\RemovesTeamMembers;
use HotwiredLaravel\Hotstream\Hotstream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TeamUsersController
{
    public function index($teamId)
    {
        $team = Hotstream::newTeamModel()->findOrFail($teamId);

        if (Gate::denies('view', $team)) {
            abort(403);
        }

        return view('team-users.index', [
            'team' => $team,
        ]);
    }

    public function destroy(Request $request, RemovesTeamMembers $remover, $teamId, $userId)
    {
        $team = Hotstream::newTeamModel()->findOrFail($teamId);
        $user = Hotstream::findUserByIdOrFail($userId);

        $remover->remove($request->user(), $team, $user);

        if ($request->user()->is($user)) {
            return redirect(config('fortify.home'))->with('status', __('Left the team.'));
        }

        return redirect()->route('team-users.index', $team)->with('status', __('Member removed.'));
    }
}
