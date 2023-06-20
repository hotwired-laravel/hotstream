<?php

namespace HotwiredLaravel\Hotstream\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class AddingTeam
{
    use Dispatchable;

    public function __construct(public User $owner)
    {
        //
    }
}
