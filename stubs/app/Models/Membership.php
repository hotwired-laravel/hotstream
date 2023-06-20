<?php

namespace App\Models;

use HotwiringLaravel\Hotstream\Models\Membership as HotstreamMembership;

class Membership extends HotstreamMembership
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}
