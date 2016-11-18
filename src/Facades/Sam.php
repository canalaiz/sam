<?php

/**
 * Canalaiz\Sam\Facades\Sam.
 *
 * @link      https://github.com/canalaiz/sam
 *
 * @copyright 2016 Alessandro Canali
 */
namespace Canalaiz\Sam\Facades;

use Illuminate\Support\Facades\Facade;

class Sam extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sam';
    }
}
