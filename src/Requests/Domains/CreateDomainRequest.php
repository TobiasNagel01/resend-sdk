<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Domains;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a new domain
 *
 * POST /domains
 *
 * @generated from the Resend OpenAPI spec (domains/create). Do not edit by hand, run `composer generate` instead.
 */
class CreateDomainRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $name  The name of the domain you want to create.
     * @param  'us-east-1'|'eu-west-1'|'sa-east-1'|'ap-northeast-1'|null  $region  The region where emails will be sent from. Possible values are us-east-1 | eu-west-1 | sa-east-1 | ap-northeast-1
     * @param  string|null  $customReturnPath  For advanced use cases, choose a subdomain for the Return-Path address. Defaults to 'send' (i.e., send.yourdomain.tld).
     * @param  bool|null  $openTracking  Track the open rate of each email.
     * @param  bool|null  $clickTracking  Track clicks within the body of each HTML email.
     * @param  'opportunistic'|'enforced'|null  $tls  TLS mode. Opportunistic attempts secure connection but falls back to unencrypted. Enforced requires TLS or email won't be sent.
     * @param  array{sending?: 'enabled'|'disabled', receiving?: 'enabled'|'disabled'}|null  $capabilities  Configure the domain capabilities for sending and receiving emails. At least one capability must be enabled.
     * @param  string|null  $trackingSubdomain  The subdomain to use for click and open tracking.
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $region = null,
        public readonly ?string $customReturnPath = null,
        public readonly ?bool $openTracking = null,
        public readonly ?bool $clickTracking = null,
        public readonly ?string $tls = null,
        public readonly ?array $capabilities = null,
        public readonly ?string $trackingSubdomain = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/domains';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'region' => $this->region,
            'custom_return_path' => $this->customReturnPath,
            'open_tracking' => $this->openTracking,
            'click_tracking' => $this->clickTracking,
            'tls' => $this->tls,
            'capabilities' => $this->capabilities,
            'tracking_subdomain' => $this->trackingSubdomain,
        ]);
    }
}
