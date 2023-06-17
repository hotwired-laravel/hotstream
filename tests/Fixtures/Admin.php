<?php

namespace Hotwired\Hotstream\Tests\Fixtures;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Hotwired\Hotstream\HasProfilePhoto;
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
