<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\ApiKeys;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an existing API key
 *
 * PATCH /api-keys/{api_key_id}
 *
 * @generated from the Resend OpenAPI spec (api-keys/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateApiKeyRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $apiKeyId  The API key ID.
     * @param  string  $name  The API key name.
     */
    public function __construct(
        public readonly string $apiKeyId,
        public readonly string $name,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api-keys/'.rawurlencode($this->apiKeyId);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
        ]);
    }
}
