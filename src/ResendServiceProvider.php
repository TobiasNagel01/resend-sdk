<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ResendServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/resend.php', 'resend');

        $this->app->singleton(Resend::class, function (Application $app): Resend {
            $config = $app->make('config')->get('resend');

            return new Resend(
                apiKey: (string) ($config['api_key'] ?? ''),
                baseUrl: (string) ($config['base_url'] ?? Resend::DEFAULT_BASE_URL),
                timeout: isset($config['timeout']) ? (float) $config['timeout'] : null,
                tries: isset($config['tries']) ? (int) $config['tries'] : null,
                retryInterval: isset($config['retry_interval']) ? (int) $config['retry_interval'] : null,
            );
        });

        $this->app->alias(Resend::class, 'resend');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/resend.php' => config_path('resend.php'),
            ], 'resend-config');
        }
    }
}
