<?php

return [
    /**
     * API Key
     */
    'api_key' => env('SMSOFFICE_API_KEY'),

    /**
     * Sender name
     */
    'sender' => env('SMSOFFICE_SENDER'),

    /**
     * SMS Driver
     *
     * Supported: "log" and "sms"
     */
    'driver' => env('SMSOFFICE_DRIVER', 'sms'),
];