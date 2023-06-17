<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Hotwired\Hotstream\Hotstream;
use Illuminate\Http\Request;

class CurrentTeamsController
{
    public function update(Request $request, $team)
    {
        $team = Hotstream::newTeamModel()->findOrFail($team);

        if (! $request->user()->switchTeam($team)) {
            abort(403);
        }

        return redirect(config('fortify.home'), 303)->with('status', __('Switched to :name.', ['name' => $team->name]));
    }
}
