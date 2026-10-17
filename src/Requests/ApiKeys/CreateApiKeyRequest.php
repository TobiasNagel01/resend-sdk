<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\ApiKeys;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a new API key
 *
 * POST /api-keys
 *
 * @generated from the Resend OpenAPI spec (api-keys/create). Do not edit by hand, run `composer generate` instead.
 */
class CreateApiKeyRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $name  The API key name.
     * @param  'full_access'|'sending_access'|null  $permission  The API key can have full access to Resend’s API or be only restricted to send emails. * full_access - Can create, delete, get, and update any resource. * sending_access - Can only send emails.
     * @param  string|null  $domainId  Restrict an API key to send emails only from a specific domain. Only used when the permission is sending_access.
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $permission = null,
        public readonly ?string $domainId = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api-keys';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'permission' => $this->permission,
            'domain_id' => $this->domainId,
        ]);
    }
}
