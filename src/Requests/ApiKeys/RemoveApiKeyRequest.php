<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\ApiKeys;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove an existing API key
 *
 * DELETE /api-keys/{api_key_id}
 *
 * @generated from the Resend OpenAPI spec (api-keys/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveApiKeyRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $apiKeyId  The API key ID.
     */
    public function __construct(
        public readonly string $apiKeyId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api-keys/'.rawurlencode($this->apiKeyId);
    }
}
