<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Broadcasts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Broadcast;

/**
 * Retrieve a single broadcast
 *
 * GET /broadcasts/{id}
 *
 * @generated from the Resend OpenAPI spec (broadcasts/get). Do not edit by hand, run `composer generate` instead.
 */
class GetBroadcastRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $id  The Broadcast ID.
     */
    public function __construct(
        public readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/broadcasts/'.rawurlencode($this->id);
    }

    public function createDtoFromResponse(Response $response): Broadcast
    {
        return Broadcast::fromArray($response->json());
    }
}
