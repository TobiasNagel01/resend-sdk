<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Domains\CreateDomainClaimRequest;
use TobiasNagel01\ResendSdk\Requests\Domains\CreateDomainRequest;
use TobiasNagel01\ResendSdk\Requests\Domains\GetDomainClaimRequest;
use TobiasNagel01\ResendSdk\Requests\Domains\GetDomainRequest;
use TobiasNagel01\ResendSdk\Requests\Domains\ListDomainsRequest;
use TobiasNagel01\ResendSdk\Requests\Domains\RemoveDomainRequest;
use TobiasNagel01\ResendSdk\Requests\Domains\UpdateDomainRequest;
use TobiasNagel01\ResendSdk\Requests\Domains\VerifyDomainClaimRequest;
use TobiasNagel01\ResendSdk\Requests\Domains\VerifyDomainRequest;

/**
 * Domains endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Domains extends BaseResource
{
    /**
     * Create a new domain
     *
     * @param  string  $name  The name of the domain you want to create.
     * @param  'us-east-1'|'eu-west-1'|'sa-east-1'|'ap-northeast-1'|null  $region  The region where emails will be sent from. Possible values are us-east-1 | eu-west-1 | sa-east-1 | ap-northeast-1
     * @param  string|null  $customReturnPath  For advanced use cases, choose a subdomain for the Return-Path address. Defaults to 'send' (i.e., send.yourdomain.tld).
     * @param  bool|null  $openTracking  Track the open rate of each email.
     * @param  bool|null  $clickTracking  Track clicks within the body of each HTML email.
     * @param  'opportunistic'|'enforced'|null  $tls  TLS mode. Opportunistic attempts secure connection but falls back to unencrypted. Enforced requires TLS or email won't be sent.
     * @param  array{sending?: 'enabled'|'disabled', receiving?: 'enabled'|'disabled'}|null  $capabilities  Configure the domain capabilities for sending and receiving emails. At least one capability must be enabled.
     * @param  string|null  $trackingSubdomain  The subdomain to use for click and open tracking.
     */
    public function create(
        string $name,
        ?string $region = null,
        ?string $customReturnPath = null,
        ?bool $openTracking = null,
        ?bool $clickTracking = null,
        ?string $tls = null,
        ?array $capabilities = null,
        ?string $trackingSubdomain = null,
    ): Response {
        return $this->connector->send(new CreateDomainRequest(
            $name,
            $region,
            $customReturnPath,
            $openTracking,
            $clickTracking,
            $tls,
            $capabilities,
            $trackingSubdomain,
        ));
    }

    /**
     * Retrieve a list of domains
     *
     * `$response->dto()` returns a ListResponse<Domain>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListDomainsRequest($limit, $after, $before));
    }

    /**
     * Retrieve a single domain
     *
     * `$response->dto()` returns a Domain.
     *
     * @param  string  $domainId  The ID of the domain.
     */
    public function get(string $domainId): Response
    {
        return $this->connector->send(new GetDomainRequest($domainId));
    }

    /**
     * Update an existing domain
     *
     * @param  string  $domainId  The ID of the domain.
     * @param  bool|null  $openTracking  Track the open rate of each email.
     * @param  bool|null  $clickTracking  Track clicks within the body of each HTML email.
     * @param  'opportunistic'|'enforced'|null  $tls  enforced | opportunistic.
     * @param  array{sending?: 'enabled'|'disabled', receiving?: 'enabled'|'disabled'}|null  $capabilities  Configure the domain capabilities for sending and receiving emails. At least one capability must be enabled.
     * @param  string|null  $trackingSubdomain  The subdomain to use for click and open tracking.
     */
    public function update(
        string $domainId,
        ?bool $openTracking = null,
        ?bool $clickTracking = null,
        ?string $tls = null,
        ?array $capabilities = null,
        ?string $trackingSubdomain = null,
    ): Response {
        return $this->connector->send(new UpdateDomainRequest(
            $domainId,
            $openTracking,
            $clickTracking,
            $tls,
            $capabilities,
            $trackingSubdomain,
        ));
    }

    /**
     * Remove an existing domain
     *
     * @param  string  $domainId  The ID of the domain.
     */
    public function remove(string $domainId): Response
    {
        return $this->connector->send(new RemoveDomainRequest($domainId));
    }

    /**
     * Verify an existing domain
     *
     * @param  string  $domainId  The ID of the domain.
     */
    public function verify(string $domainId): Response
    {
        return $this->connector->send(new VerifyDomainRequest($domainId));
    }

    /**
     * Claim a domain
     *
     * `$response->dto()` returns a DomainClaim.
     *
     * @param  string  $name  The name of the domain you want to claim.
     * @param  'us-east-1'|'eu-west-1'|'sa-east-1'|'ap-northeast-1'|null  $region  The region where emails will be sent from. Possible values are us-east-1 | eu-west-1 | sa-east-1 | ap-northeast-1
     * @param  string|null  $customReturnPath  For advanced use cases, choose a subdomain for the Return-Path address. Defaults to 'send' (i.e., send.yourdomain.tld).
     * @param  bool|null  $openTracking  Track the open rate of each email.
     * @param  bool|null  $clickTracking  Track clicks within the body of each HTML email.
     * @param  string|null  $trackingSubdomain  The subdomain to use for click and open tracking.
     */
    public function createClaim(
        string $name,
        ?string $region = null,
        ?string $customReturnPath = null,
        ?bool $openTracking = null,
        ?bool $clickTracking = null,
        ?string $trackingSubdomain = null,
    ): Response {
        return $this->connector->send(new CreateDomainClaimRequest(
            $name,
            $region,
            $customReturnPath,
            $openTracking,
            $clickTracking,
            $trackingSubdomain,
        ));
    }

    /**
     * Retrieve a domain claim
     *
     * `$response->dto()` returns a DomainClaim.
     *
     * @param  string  $domainId  The ID of the placeholder domain created by the claim.
     */
    public function getClaim(string $domainId): Response
    {
        return $this->connector->send(new GetDomainClaimRequest($domainId));
    }

    /**
     * Verify a domain claim
     *
     * `$response->dto()` returns a DomainClaim.
     *
     * @param  string  $domainId  The ID of the placeholder domain created by the claim.
     */
    public function verifyClaim(string $domainId): Response
    {
        return $this->connector->send(new VerifyDomainClaimRequest($domainId));
    }
}
