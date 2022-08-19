<?php

namespace Parsadanashvili\LaravelSmsOffice\Exceptions;

use Exception;

class ApiCredentialsException extends Exception
{
    public static function apiKeyNotProvided()
    {
        return new static('API key is not provided.');
    }

    public static function senderNotProvided()
    {
        return new static('Sender is not provided.');
    }
}