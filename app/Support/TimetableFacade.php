<?php

namespace App\Support;

use Illuminate\Support\Facades\Facade;

class TimetableFacade extends Facade{

    protected static function getFacadeAccessor() {

        return 'timetable';
    }
}
