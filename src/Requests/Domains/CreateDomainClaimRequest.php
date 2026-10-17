<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Domains;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Data\DomainClaim;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Claim a domain
 *
 * Start a claim for a domain that another Resend account has already verified. The domain is recreated under your account with fresh DKIM keys, so the previous account's DNS records cannot be reused. Returns a TXT record to add to your DNS to prove ownership. Uses the same request body as creating a domain.
 *
 * POST /domains/claim
 *
 * @generated from the Resend OpenAPI spec (domains/create-claim). Do not edit by hand, run `composer generate` instead.
 */
class CreateDomainClaimRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $name  The name of the domain you want to claim.
     * @param  'us-east-1'|'eu-west-1'|'sa-east-1'|'ap-northeast-1'|null  $region  The region where emails will be sent from. Possible values are us-east-1 | eu-west-1 | sa-east-1 | ap-northeast-1
     * @param  string|null  $customReturnPath  For advanced use cases, choose a subdomain for the Return-Path address. Defaults to 'send' (i.e., send.yourdomain.tld).
     * @param  bool|null  $openTracking  Track the open rate of each email.
     * @param  bool|null  $clickTracking  Track clicks within the body of each HTML email.
     * @param  string|null  $trackingSubdomain  The subdomain to use for click and open tracking.
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $region = null,
        public readonly ?string $customReturnPath = null,
        public readonly ?bool $openTracking = null,
        public readonly ?bool $clickTracking = null,
        public readonly ?string $trackingSubdomain = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/domains/claim';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'region' => $this->region,
            'custom_return_path' => $this->customReturnPath,
            'open_tracking' => $this->openTracking,
            'click_tracking' => $this->clickTracking,
            'tracking_subdomain' => $this->trackingSubdomain,
        ]);
    }

    public function createDtoFromResponse(Response $response): DomainClaim
    {
        return DomainClaim::fromArray($response->json());
    }
}
