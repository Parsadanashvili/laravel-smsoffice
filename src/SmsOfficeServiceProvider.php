<?php

namespace Parsadanashvili\LaravelSmsOffice;

use Illuminate\Support\ServiceProvider;

class SmsOfficeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     *@return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/smsoffice.php' => config_path('smsoffice.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     *@return void
     */
    public function register()
    {
        $this->app->singleton(SmsOffice::class, function () {
            return new SmsOffice();
        });        
				$this->app->alias(SmsOffice::class, 'sms-office');
    }
}