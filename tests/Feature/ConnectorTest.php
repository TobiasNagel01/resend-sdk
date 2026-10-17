<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use TobiasNagel01\ResendSdk\Exceptions\ResendException;
use TobiasNagel01\ResendSdk\Requests\Domains\ListDomainsRequest;
use TobiasNagel01\ResendSdk\Resend;

it('sends requests to the Resend API with a bearer token', function () {
    $mockClient = new MockClient([MockResponse::make(['object' => 'list', 'data' => []])]);

    $response = resend($mockClient)->domains()->list();
    $psrRequest = $response->getPsrRequest();

    expect((string) $psrRequest->getUri())->toBe('https://api.resend.com/domains')
        ->and($psrRequest->getHeaderLine('Authorization'))->toBe('Bearer re_test_key')
        ->and($psrRequest->getHeaderLine('Accept'))->toBe('application/json')
        ->and($psrRequest->getHeaderLine('User-Agent'))->toBe('tobiasnagel01/resend-sdk');

    $mockClient->assertSent(ListDomainsRequest::class);
});

it('supports a custom base url', function () {
    $mockClient = new MockClient([MockResponse::make([])]);

    $response = (new Resend('re_test_key', 'https://resend.test/'))
        ->withMockClient($mockClient)
        ->usage()
        ->get();

    expect((string) $response->getPsrRequest()->getUri())->toBe('https://resend.test/usage');
});

it('throws a ResendException with the error details on failure', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'statusCode' => 422,
            'name' => 'validation_error',
            'message' => 'The `to` field must be a valid email.',
        ], 422),
    ]);

    try {
        resend($mockClient)->emails()->send(from: 'Acme <hi@acme.com>', to: 'nope', subject: 'Hi', html: '<p>Hi</p>');
        $this->fail('Expected a ResendException.');
    } catch (ResendException $exception) {
        expect($exception->statusCode())->toBe(422)
            ->and($exception->getCode())->toBe(422)
            ->and($exception->errorName)->toBe('validation_error')
            ->and($exception->errorMessage)->toBe('The `to` field must be a valid email.')
            ->and($exception->getMessage())->toBe('Resend API error (422, validation_error): The `to` field must be a valid email.');
    }
});

it('falls back to the raw body when the error is not json', function () {
    $mockClient = new MockClient([MockResponse::make('Bad Gateway', 502)]);

    expect(fn () => resend($mockClient)->domains()->list())
        ->toThrow(ResendException::class, 'Bad Gateway');
});
