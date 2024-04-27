<?php

namespace App\Service;

use Illuminate\Support\Facades\Facade;

class Tenants 
{
    protected static function getFacadeAccessor()
    {
        return 'Tenants';
    }

}
