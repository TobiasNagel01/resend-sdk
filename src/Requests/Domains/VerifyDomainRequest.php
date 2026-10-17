<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Domains;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Verify an existing domain
 *
 * Triggers verification of the domain's DNS records including DKIM, SPF, and the tracking CNAME (if a tracking subdomain is configured).
 *
 * POST /domains/{domain_id}/verify
 *
 * @generated from the Resend OpenAPI spec (domains/verify). Do not edit by hand, run `composer generate` instead.
 */
class VerifyDomainRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $domainId  The ID of the domain.
     */
    public function __construct(
        public readonly string $domainId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/domains/'.rawurlencode($this->domainId).'/verify';
    }
}
