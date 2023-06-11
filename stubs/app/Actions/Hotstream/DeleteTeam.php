<?php

namespace App\Actions\Hotstream;

use Hotwired\Hotstream\Contracts\DeletesTeams;
use App\Models\Team;

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
