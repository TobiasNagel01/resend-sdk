<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Domains;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\DomainClaim;

/**
 * Verify a domain claim
 *
 * Trigger asynchronous DNS verification and ownership transfer for a domain claim. The claim stays `pending` while verification runs; poll the retrieve endpoint for status. Once `completed`, the transferred domain has new DKIM records that must be added to DNS and verified via the standard domain verify endpoint.
 *
 * POST /domains/{domain_id}/claim/verify
 *
 * @generated from the Resend OpenAPI spec (domains/verify-claim). Do not edit by hand, run `composer generate` instead.
 */
class VerifyDomainClaimRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $domainId  The ID of the placeholder domain created by the claim.
     */
    public function __construct(
        public readonly string $domainId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/domains/'.rawurlencode($this->domainId).'/claim/verify';
    }

    public function createDtoFromResponse(Response $response): DomainClaim
    {
        return DomainClaim::fromArray($response->json());
    }
}
