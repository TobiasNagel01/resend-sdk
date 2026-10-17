<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Domains;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove an existing domain
 *
 * DELETE /domains/{domain_id}
 *
 * @generated from the Resend OpenAPI spec (domains/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveDomainRequest extends Request
{
    protected Method $method = Method::DELETE;

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
}
