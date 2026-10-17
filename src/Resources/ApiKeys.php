<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\ApiKeys\CreateApiKeyRequest;
use TobiasNagel01\ResendSdk\Requests\ApiKeys\ListApiKeysRequest;
use TobiasNagel01\ResendSdk\Requests\ApiKeys\RemoveApiKeyRequest;
use TobiasNagel01\ResendSdk\Requests\ApiKeys\UpdateApiKeyRequest;

/**
 * ApiKeys endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class ApiKeys extends BaseResource
{
    /**
     * Create a new API key
     *
     * @param  string  $name  The API key name.
     * @param  'full_access'|'sending_access'|null  $permission  The API key can have full access to Resend’s API or be only restricted to send emails. * full_access - Can create, delete, get, and update any resource. * sending_access - Can only send emails.
     * @param  string|null  $domainId  Restrict an API key to send emails only from a specific domain. Only used when the permission is sending_access.
     */
    public function create(string $name, ?string $permission = null, ?string $domainId = null): Response
    {
        return $this->connector->send(new CreateApiKeyRequest($name, $permission, $domainId));
    }

    /**
     * Retrieve a list of API keys
     *
     * `$response->dto()` returns a ListResponse<ApiKey>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListApiKeysRequest($limit, $after, $before));
    }

    /**
     * Update an existing API key
     *
     * @param  string  $apiKeyId  The API key ID.
     * @param  string  $name  The API key name.
     */
    public function update(string $apiKeyId, string $name): Response
    {
        return $this->connector->send(new UpdateApiKeyRequest($apiKeyId, $name));
    }

    /**
     * Remove an existing API key
     *
     * @param  string  $apiKeyId  The API key ID.
     */
    public function remove(string $apiKeyId): Response
    {
        return $this->connector->send(new RemoveApiKeyRequest($apiKeyId));
    }
}
