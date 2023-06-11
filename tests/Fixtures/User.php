<?php

namespace Hotwired\Hotstream\Tests\Fixtures;

use App\Models\User as BaseUser;
use Hotwired\Hotstream\HasProfilePhoto;
use Hotwired\Hotstream\HasTeams;
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
