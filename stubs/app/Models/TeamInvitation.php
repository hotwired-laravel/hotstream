<?php

namespace App\Models;

use HotwiredLaravel\Hotstream\Hotstream;
use HotwiredLaravel\Hotstream\Models\TeamInvitation as HotstreamTeamInvitation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamInvitation extends HotstreamTeamInvitation
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'role',
    ];

    /**
     * Get the team that the invitation belongs to.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Hotstream::teamModel());
    }
}
