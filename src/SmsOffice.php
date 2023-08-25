<?php

namespace Parsadanashvili\LaravelSmsOffice;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Parsadanashvili\LaravelSmsOffice\Exceptions\ApiCredentialsException;
use Parsadanashvili\LaravelSmsOffice\Exceptions\InvalidNumberException;

class SmsOffice
{
    const SEND_URL = '/api/v2/send/?key=%s&destination=%s&sender=%s&content=%s&urgent=true';
    const BALANCE_URL = '/api/getBalance?key=%s';

    protected $apiKey;

    protected $sender;

    protected $driver;

    protected $client;

    public function __construct()
    {
        $this->apiKey = config('smsoffice.api_key');
        $this->sender = config('smsoffice.sender');
        $this->driver = config('smsoffice.driver');

        $this->client = new Client([
            'base_uri' => 'http://smsoffice.ge',
        ]);
    }

    public function send($destination, $message)
    {
        $destination = $this->formatDestination($destination);
        $message = $this->encodeMessage($message);

        if ($this->driver === 'log') {
            return Log::info('SMS: ' . $destination . ' - ' . $message);
        }

        if (empty($this->apiKey)) {
            throw ApiCredentialsException::apiKeyNotProvided();
        }

        if (empty($this->sender)) {
            throw ApiCredentialsException::senderNotProvided();
        }

        $url = sprintf(self::SEND_URL, $this->apiKey, $destination, $this->sender, $message);

        $response = $this->client->request('GET', $url)->getBody()->getContents();
        $response = json_decode($response);

        return $response;
    }

    public function balance()
    {
        if (empty($this->apiKey)) {
            throw ApiCredentialsException::apiKeyNotProvided();
        }

        $url = sprintf(self::BALANCE_URL, $this->apiKey);

        $response = $this->client->request('GET', $url)->getBody()->getContents();
        $response = json_decode($response);

        return $response;
    }

    private function formatDestination($destination)
    {
        preg_match_all('!\d+!', $destination, $matches);
        $destination = implode($matches[0]);

        if (substr($destination, 0, 3) != '995') {
            $destination = '995' . $destination;
        }

        if (strlen($destination) !== 12) {
            throw InvalidNumberException::invalidNumber();
        }

        return $destination;
    }

    private function encodeMessage($message)
    {
        if (strlen($message) !== strlen(mb_convert_encoding($message, "UTF-8", mb_detect_encoding($message)))) {
            $message = rawurlencode($message);
        }

        return $message;
    }
}
