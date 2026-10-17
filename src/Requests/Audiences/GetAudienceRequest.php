<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Audiences;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Audience;

/**
 * Retrieve a single audience
 *
 * Deprecated: Use Segments instead. These endpoints still work, but will be removed in the future.
 *
 * @deprecated
 *
 * GET /audiences/{id}
 *
 * @generated from the Resend OpenAPI spec (audiences/get). Do not edit by hand, run `composer generate` instead.
 */
class GetAudienceRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $id  The Audience ID.
     */
    public function __construct(
        public readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/audiences/'.rawurlencode($this->id);
    }

    public function createDtoFromResponse(Response $response): Audience
    {
        return Audience::fromArray($response->json());
    }
}
