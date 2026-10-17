<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Suppressions;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Suppression;

/**
 * Retrieve a single suppression by ID or email
 *
 * GET /suppressions/{suppression}
 *
 * @generated from the Resend OpenAPI spec (suppressions/get). Do not edit by hand, run `composer generate` instead.
 */
class GetSuppressionRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $suppression  The Suppression ID or email address.
     */
    public function __construct(
        public readonly string $suppression,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/suppressions/'.rawurlencode($this->suppression);
    }

    public function createDtoFromResponse(Response $response): Suppression
    {
        return Suppression::fromArray($response->json());
    }
}
