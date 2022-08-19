<?php

namespace Parsadanashvili\LaravelSmsOffice;

use Illuminate\Notifications\Notification;
use Parsadanashvili\LaravelSmsOffice\Exceptions\InvalidNumberException;

class SmsOfficeChannel
{
    protected $smsOffice;

    protected $routeName = 'Sms';

    public function __construct(SmsOffice $smsOffice)
    {
        $this->smsOffice = $smsOffice;
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);

        if (!$to = $notifiable->routeNotificationFor($this->routeName)) {
            throw InvalidNumberException::numberNotProvided();
        }

        if(is_array($message)) {
            $message = data_get($message, 'message');
        }
        
        $this->smsOffice->send($to, $message);
    }
}