<?php

namespace Mamikos\Tikus\Facades;

use Illuminate\Support\Facades\Facade;

class TikusFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tikus';
    }
}
