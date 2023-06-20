<?php

namespace HotwiredLaravel\Hotstream\Tests\Fixtures;

use HotwiredLaravel\Hotstream\HasProfilePhoto;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasProfilePhoto;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
