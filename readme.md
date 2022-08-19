# Laravel SMSOffice

This package allows you to send SMS using the [SMSOffice](http://smsoffice.ge) API

## Install
```bash
composer require parsadanashvili/laravel-smsoffice
```

#### If you run Laravel 5.4 (or lower), then follow next step:

You have to manually add a service provider in your `config/app.php` file. Open `config/app.php` and add `SmsOfficeServiceProvider` to the providers array.

```php
// config/app.php
'providers' => [
    # Other providers
    Parsadanashvili\LaravelSmsOffice\SmsOfficeServiceProvider::class,
],
```

Then publish configuration:

```bash
php artisan vendor:publish --provider="Parsadanashvili\LaravelSmsOffice\SmsOfficeServiceProvider"
```

## Environment variables

```dosini
SMSOFFICE_API_KEY=
SMSOFFICE_SENDER=
SMSOFFICE_DRIVER=
```

## Development

For development, add `SMSOFFICE_DRIVER=log` to your `.env` file

## Usage

### Using notification class

In `User` model, add `routeNotificationForSms()` method and return user's phone number

```php
namespace App\Models;

class User extends Authenticatable
{
    // Other Code...

    public function routeNotificationForSms()
    {
        return $this->phone;
    }
}
```

Create notification class:

```bash
php artisan make:notification SmsNotification
```

Now import `SmsOfficeChannel` and add it to `via()` method.

```php
use Illuminate\Notifications\Notification;
use Parsadanashvili\LaravelSmsOffice\SmsOfficeChannel;

class SMSNotification extends Notification
{
    public function via($notifiable)
    {
        return [SmsOfficeChannel::class];
    }
    
    public function toSms($notifiable)
    {
        return 'Your Notification Content Here';
    }
}
```

### Without notification class

```php
use Parsadanashvili\LaravelSmsOffice\SmsOffice;

public function sms(SmsOffice $smsOffice)
{
    $smsOffice->send('599123456', 'Your Message Here');
}
```