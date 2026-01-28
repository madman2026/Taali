<?php

namespace App\Contracts\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static tryFrom(array $array)
 */
class DTO extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'DTO';
    }
}
