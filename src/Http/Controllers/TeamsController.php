<?php

namespace Hotwired\Hotstream\Http\Controllers;

use App\Http\Controllers\Controller;
use Hotwired\Hotstream\Actions\ValidateTeamDeletion;
use Hotwired\Hotstream\Contracts\CreatesTeams;
use Hotwired\Hotstream\Contracts\DeletesTeams;
use Hotwired\Hotstream\Contracts\UpdatesTeamNames;
use Hotwired\Hotstream\Hotstream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Tonysm\TurboLaravel\Http\Controllers\Concerns\InteractsWithTurboNativeNavigation;

class TeamsController extends Controller
{
    use RedirectsActions;
    use InteractsWithTurboNativeNavigation;

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request, CreatesTeams $creator)
    {
        $creator->create($request->user(), $request->all());

        return $this->redirectPath($creator)->with('status', __('Team created.'));
    }

    public function show($teamId)
    {
        $team = Hotstream::newTeamModel()->findOrFail($teamId);

        Gate::authorize('view', $team);

        return view('teams.show', [
            'team' => $team,
        ]);
    }

    public function edit($teamId)
    {
        $team = Hotstream::newTeamModel()->findOrFail($teamId);

        Gate::authorize('update', $team);

        return view('teams.edit', [
            'team' => $team,
        ]);
    }

    public function update(Request $request, UpdatesTeamNames $updater, $teamId)
    {
        $team = Hotstream::newTeamModel()->findOrFail($teamId);

        $updater->update($request->user(), $team, $request->all());

        return $this->recedeOrRedirectBack(route('teams.edit', $team))->with('status', __('Team updated.'));
    }

    public function delete($teamId)
    {
        $team = Hotstream::newTeamModel()->findOrFail($teamId);

        Gate::authorize('delete', $team);

        return view('teams.delete', [
            'team' => $team,
        ]);
    }

    public function destroy(Request $request, ValidateTeamDeletion $validation, DeletesTeams $deleter, $teamId)
    {
        $team = Hotstream::newTeamModel()->findOrFail($teamId);

        $validation->validate($request->user(), $team);

        $deleter->delete($team);

        return redirect(config('fortify.home'))->with('status', __('Team deleted.'));
    }
}
