<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Audiences;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Audience;
use TobiasNagel01\ResendSdk\Data\ListResponse;

/**
 * Retrieve a list of audiences
 *
 * Deprecated: Use Segments instead. These endpoints still work, but will be removed in the future.
 *
 * @deprecated
 *
 * GET /audiences
 *
 * @generated from the Resend OpenAPI spec (audiences/list). Do not edit by hand, run `composer generate` instead.
 */
class ListAudiencesRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/audiences';
    }

    /**
     * @return ListResponse<Audience>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), Audience::fromArray(...));
    }
}
