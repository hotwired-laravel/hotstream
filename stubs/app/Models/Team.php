<?php

namespace App\Models;

use Hotwired\Hotstream\Events\TeamCreated;
use Hotwired\Hotstream\Events\TeamDeleted;
use Hotwired\Hotstream\Events\TeamUpdated;
use Hotwired\Hotstream\Models\Team as HotstreamTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends HotstreamTeam
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'personal_team',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];
}
