<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Domains;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an existing domain
 *
 * PATCH /domains/{domain_id}
 *
 * @generated from the Resend OpenAPI spec (domains/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateDomainRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $domainId  The ID of the domain.
     * @param  bool|null  $openTracking  Track the open rate of each email.
     * @param  bool|null  $clickTracking  Track clicks within the body of each HTML email.
     * @param  'opportunistic'|'enforced'|null  $tls  enforced | opportunistic.
     * @param  array{sending?: 'enabled'|'disabled', receiving?: 'enabled'|'disabled'}|null  $capabilities  Configure the domain capabilities for sending and receiving emails. At least one capability must be enabled.
     * @param  string|null  $trackingSubdomain  The subdomain to use for click and open tracking.
     */
    public function __construct(
        public readonly string $domainId,
        public readonly ?bool $openTracking = null,
        public readonly ?bool $clickTracking = null,
        public readonly ?string $tls = null,
        public readonly ?array $capabilities = null,
        public readonly ?string $trackingSubdomain = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/domains/'.rawurlencode($this->domainId);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'open_tracking' => $this->openTracking,
            'click_tracking' => $this->clickTracking,
            'tls' => $this->tls,
            'capabilities' => $this->capabilities,
            'tracking_subdomain' => $this->trackingSubdomain,
        ]);
    }
}
