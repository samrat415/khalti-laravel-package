<?php

namespace Khalti\KhaltiLaravel\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Khalti\KhaltiLaravel\Khalti;
use Khalti\KhaltiLaravel\KhaltiLaravelServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Khalti\\KhaltiLaravel\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            KhaltiLaravelServiceProvider::class,
            Khalti::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        //        // Load the configuration file
        //        $configFilePath = __DIR__.'/../config/khalti-laravel.php';
        //
        //        if (file_exists($configFilePath)) {
        //            $config = include $configFilePath;
        //
        //            // Set the loaded configuration values
        //            $app['config']->set('khalti-laravel', $config);
        //        } else {
        //            throw new \Exception("Configuration file khalti-laravel.php not found at: $configFilePath");
        //        }
        /*
        $migration = include __DIR__.'/../database/migrations/create_khalti-laravel_table.php.stub';
        $migration->up();
        */
    }
}
