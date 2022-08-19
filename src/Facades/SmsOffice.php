<?php

namespace Parsadanashvili\LaravelSmsOffice\Facades;

use Illuminate\Support\Facades\Facade;

class SmsOffice extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Parsadanashvili\LaravelSmsOffice\SmsOffice::class;
    }
}
