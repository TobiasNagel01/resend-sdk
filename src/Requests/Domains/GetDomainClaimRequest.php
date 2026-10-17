<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Domains;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\DomainClaim;

/**
 * Retrieve a domain claim
 *
 * Retrieve the latest claim for the placeholder domain created by the claim.
 *
 * GET /domains/{domain_id}/claim
 *
 * @generated from the Resend OpenAPI spec (domains/get-claim). Do not edit by hand, run `composer generate` instead.
 */
class GetDomainClaimRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $domainId  The ID of the placeholder domain created by the claim.
     */
    public function __construct(
        public readonly string $domainId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/domains/'.rawurlencode($this->domainId).'/claim';
    }

    public function createDtoFromResponse(Response $response): DomainClaim
    {
        return DomainClaim::fromArray($response->json());
    }
}
