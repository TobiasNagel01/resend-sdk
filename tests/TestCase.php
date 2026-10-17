<?php

namespace TobiasNagel01\ResendSdk\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Saloon\Laravel\SaloonServiceProvider;
use TobiasNagel01\ResendSdk\Facades\Resend;
use TobiasNagel01\ResendSdk\ResendServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [SaloonServiceProvider::class, ResendServiceProvider::class];
    }

    protected function getPackageAliases($app): array
    {
        return ['Resend' => Resend::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('resend.api_key', 're_laravel_key');
    }
}
