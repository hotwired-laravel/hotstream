<?php

namespace HotwiredLaravel\Hotstream\Tests\Fixtures;

use App\Models\User as BaseUser;
use HotwiredLaravel\Hotstream\HasProfilePhoto;
use HotwiredLaravel\Hotstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends BaseUser
{
    use HasApiTokens, HasProfilePhoto, HasTeams;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
