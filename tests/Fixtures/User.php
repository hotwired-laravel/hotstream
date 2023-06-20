<?php

namespace HotwiringLaravel\Hotstream\Tests\Fixtures;

use App\Models\User as BaseUser;
use HotwiringLaravel\Hotstream\HasProfilePhoto;
use HotwiringLaravel\Hotstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends BaseUser
{
    use HasApiTokens, HasTeams, HasProfilePhoto;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
