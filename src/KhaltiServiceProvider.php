<?php

namespace Khalti\KhaltiLaravel;

use Illuminate\Support\ServiceProvider;
use Khalti\KhaltiLaravel\Service\KhaltiService;
class KhaltiServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Debugging: Dump the retrieved configuration
        $config = $this->app->make('config')->get('khalti-laravel');

        // Bind KhaltiService with a closure to inject the configuration
        $this->app->singleton(KhaltiService::class, function ($app) {
            // Retrieve configuration from Laravel's config() function
            $config = $app->make('config')->get('khalti-laravel');

            // Debugging: Dump the retrieved configuration

            // Return a new instance of KhaltiService with the configuration injected
            return new KhaltiService($config);
        });
    }
}
