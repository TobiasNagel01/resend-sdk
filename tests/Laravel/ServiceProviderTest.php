<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use TobiasNagel01\ResendSdk\Facades\Resend as ResendFacade;
use TobiasNagel01\ResendSdk\Requests\Emails\SendEmailRequest;
use TobiasNagel01\ResendSdk\Resend;

it('registers the connector as a singleton configured from config', function () {
    config()->set('resend.base_url', 'https://resend.test');
    config()->set('resend.tries', '3');

    $resend = app(Resend::class);

    expect($resend)->toBe(app('resend'))
        ->and($resend->resolveBaseUrl())->toBe('https://resend.test')
        ->and($resend->tries)->toBe(3)
        ->and($resend->getRequestTimeout())->toBe(30.0);
});

it('resolves the facade and can be faked with Saloon', function () {
    Saloon::fake([SendEmailRequest::class => MockResponse::make(['id' => 'abc'])]);

    $response = ResendFacade::emails()->send('a@acme.com', 'b@acme.com', 'Hi', text: 'Hi');

    expect($response->json('id'))->toBe('abc')
        ->and($response->getPsrRequest()->getHeaderLine('Authorization'))->toBe('Bearer re_laravel_key');

    Saloon::assertSent(SendEmailRequest::class);
});

it('publishes the config file', function () {
    $this->artisan('vendor:publish', ['--tag' => 'resend-config', '--force' => true])->assertSuccessful();

    expect(config_path('resend.php'))->toBeFile();

    unlink(config_path('resend.php'));
});
