<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Hotwired\Hotstream\Contracts\AddsTeamMembers;
use Hotwired\Hotstream\Hotstream;

class AcceptedTeamInvitationsController
{
    public function update(AddsTeamMembers $members, $teamInvitationId)
    {
        $invitation = Hotstream::newTeamInvitationModel()->findOrFail($teamInvitationId);

        $members->add(
            $invitation->team->owner,
            $invitation->team,
            $invitation->email,
            $invitation->role
        );

        $invitation->delete();

        return redirect(config('fortify.home'));
        // ->banner(
        //     __('Great! You have accepted the invitation to join the :team team.', ['team' => $invitation->team->name]),
        // );
    }
}
