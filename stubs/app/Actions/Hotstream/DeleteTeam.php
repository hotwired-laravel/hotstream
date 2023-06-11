<?php

namespace App\Actions\Hotstream;

use App\Models\Team;
use Hotwired\Hotstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     */
    public function delete(Team $team): void
    {
        $team->purge();
    }
}
