<?php

namespace Khalti\KhaltiLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Khalti\KhaltiLaravel\KhaltiLaravel
 */
class KhaltiLaravel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Khalti\KhaltiLaravel\KhaltiLaravel::class;
    }
}
