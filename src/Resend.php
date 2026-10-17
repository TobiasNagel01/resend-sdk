<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\Traits\Plugins\HasTimeout;
use Throwable;
use TobiasNagel01\ResendSdk\Concerns\HasResources;
use TobiasNagel01\ResendSdk\Exceptions\ResendException;

class Resend extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;
    use HasResources;
    use HasTimeout;

    public const string DEFAULT_BASE_URL = 'https://api.resend.com';

    protected float $connectTimeout = 10;

    protected float $requestTimeout = 30;

    public function __construct(
        protected readonly string $apiKey,
        protected readonly string $baseUrl = self::DEFAULT_BASE_URL,
        ?float $timeout = null,
        ?int $tries = null,
        ?int $retryInterval = null,
    ) {
        if ($timeout !== null) {
            $this->requestTimeout = $timeout;
        }

        $this->tries = $tries;
        $this->retryInterval = $retryInterval;
    }

    public function resolveBaseUrl(): string
    {
        return rtrim($this->baseUrl, '/');
    }

    protected function defaultAuth(): Authenticator
    {
        return new TokenAuthenticator($this->apiKey);
    }

    protected function defaultHeaders(): array
    {
        return [
            'User-Agent' => 'tobiasnagel01/resend-sdk',
        ];
    }

    public function getRequestException(Response $response, ?Throwable $senderException): Throwable
    {
        return ResendException::fromResponse($response, $senderException);
    }
}
