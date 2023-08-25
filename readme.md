<!-- # Laravel SMSOffice Package

[![Latest Stable Version](https://img.shields.io/packagist/v/parsadanashvili/laravel-smsoffice.svg)](https://packagist.org/packages/parsadanashvili/laravel-smsoffice)
[![Total Downloads](https://img.shields.io/packagist/dt/parsadanashvili/laravel-smsoffice.svg)](https://packagist.org/packages/parsadanashvili/laravel-smsoffice)
[![Downloads Month](https://img.shields.io/packagist/dm/parsadanashvili/laravel-smsoffice.svg)](https://packagist.org/packages/parsadanashvili/laravel-smsoffice)

This package allows you to send SMS using the [SMSOffice](http://smsoffice.ge) API

## Credits

[This repository is a fork from original lotuashvili/laravel-smsoffice](https://github.com/Lotuashvili/laravel-smsoffice)

## Installation

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
``` -->

# Laravel SMSOffice Package

[![Latest Stable Version](https://img.shields.io/packagist/v/parsadanashvili/laravel-smsoffice.svg)](https://packagist.org/packages/parsadanashvili/laravel-smsoffice)
[![Total Downloads](https://img.shields.io/packagist/dt/parsadanashvili/laravel-smsoffice.svg)](https://packagist.org/packages/parsadanashvili/laravel-smsoffice)
[![Downloads Month](https://img.shields.io/packagist/dm/parsadanashvili/laravel-smsoffice.svg)](https://packagist.org/packages/parsadanashvili/laravel-smsoffice)

The **Laravel SMSOffice** package allows you to easily send SMS messages using the [SMSOffice](http://smsoffice.ge) API. It provides a convenient way to integrate SMS functionality into your Laravel applications.

## Credits

This package is a fork of the original work by **lotuashvili/laravel-smsoffice**. You can find the original repository [here](https://github.com/Lotuashvili/laravel-smsoffice).

## Installation

You can install the package using Composer:

```bash
composer require parsadanashvili/laravel-smsoffice
```

If you're using Laravel 5.4 or lower, you'll need to manually add the service provider to your `config/app.php` file. Open the `config/app.php` file and add the `SmsOfficeServiceProvider` to the providers array:

```php
// config/app.php
'providers' => [
    // Other providers
    Parsadanashvili\LaravelSmsOffice\SmsOfficeServiceProvider::class,
],
```

After adding the service provider, you'll need to publish the configuration:

```bash
php artisan vendor:publish --provider="Parsadanashvili\LaravelSmsOffice\SmsOfficeServiceProvider"
```

## Configuration

You'll need to set up the following environment variables in your `.env` file:

```dosini
SMSOFFICE_API_KEY=your_api_key
SMSOFFICE_SENDER=your_default_sender
SMSOFFICE_DRIVER=your_preferred_driver
```

## Development

During development, you can set the SMS driver to `log` by adding `SMSOFFICE_DRIVER=log` to your `.env` file. This will help you simulate SMS sending by logging the actions instead.

## Usage

### Using Notifications

1. In your `User` model (or any model you want to send notifications to), add a `routeNotificationForSms()` method that returns the user's phone number:

```php
namespace App\Models;

use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Other code...

    public function routeNotificationForSms()
    {
        return $this->phone; // Adjust this to match your phone number field
    }
}
```

2. Create a notification class using the following Artisan command:

```bash
php artisan make:notification SmsNotification
```

3. Inside the generated `SmsNotification` class, import `SmsOfficeChannel` and add it to the `via()` method. Define the `toSms()` method to specify the content of your SMS:

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

4. You can now use this notification in your application to send SMS notifications to users:

```php
use App\Notifications\SMSNotification;

$user->notify(new SMSNotification());
```

### Sending SMS Directly

If you want to send SMS messages without using notifications, you can do so directly:

```php
use Parsadanashvili\LaravelSmsOffice\SmsOffice;

public function sendSms(SmsOffice $smsOffice)
{
    $smsOffice->send('599123456', 'Your Message Here');
}
```

Feel free to replace `'599123456'` with the recipient's phone number and `'Your Message Here'` with the actual message content.

This should help clarify the installation process, configuration, and usage of the **Laravel SMSOffice** package.
