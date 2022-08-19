<?php

namespace Parsadanashvili\LaravelSmsOffice\Exceptions;

use Exception;

class InvalidNumberException extends Exception
{
    public static function invalidNumber()
    {
        return new static('Phone number is invalid');
    }

    public static function numberNotProvided()
    {
        return new static('Phone number is not provided');
    }
}