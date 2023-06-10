<?php

namespace Hotwired\Hotstream\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hotwired\Hotstream\Hotstream
 */
class Hotstream extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Hotwired\Hotstream\Hotstream::class;
    }
}
