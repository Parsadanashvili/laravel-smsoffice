<?php

namespace Parsadanashvili\LaravelSmsOffice;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Parsadanashvili\LaravelSmsOffice\Exceptions\ApiCredentialsException;
use Parsadanashvili\LaravelSmsOffice\Exceptions\InvalidNumberException;

class SmsOffice {
    const SEND_URL = 'send/?key=%s&destination=%s&sender=%s&content=%s&urgent=true';

    protected $apiKey;

    protected $sender;

    protected $driver;

    protected $client;

    public function __construct() {
        $this->apiKey = config('smsoffice.api_key');
        $this->sender = config('smsoffice.sender');
        $this->driver = config('smsoffice.driver');

        $this->client = new Client([
            'base_uri' => 'http://smsoffice.ge/api/v2/',
        ]);
    }

    public function send($destination, $message)
    {
        if($this->driver === 'log') {
            return Log::info('SMS: '.$destination.' - '.$message);
        }

        $this->checkApiCredentials();

        $url = $this->url($destination, $message);

        $response = $this->client->request('GET', $url)->getBody()->getContents();
        $response = json_decode($response);

        return $response;
    }

    
    private function checkApiCredentials()
    {
        if (empty($this->apiKey)) {
            throw ApiCredentialsException::apiKeyNotProvided();
        }

        if (empty($this->sender)) {
            throw ApiCredentialsException::senderNotProvided();
        }
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
        if (strlen($message) !== strlen(utf8_decode($message))) {
            $message = rawurlencode($message);
        }

        return $message;
    }

    public function url($destination, $message)
    {
        $destination = $this->formatDestination($destination);
        $message = $this->encodeMessage($message);
        $url = sprintf(self::SEND_URL, $this->apiKey, $destination, $this->sender, $message);
        return $url;
    }
}