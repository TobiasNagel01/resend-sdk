<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Domains;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Domain;

/**
 * Retrieve a single domain
 *
 * GET /domains/{domain_id}
 *
 * @generated from the Resend OpenAPI spec (domains/get). Do not edit by hand, run `composer generate` instead.
 */
class GetDomainRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $domainId  The ID of the domain.
     */
    public function __construct(
        public readonly string $domainId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/domains/'.rawurlencode($this->domainId);
    }

    public function createDtoFromResponse(Response $response): Domain
    {
        return Domain::fromArray($response->json());
    }
}
