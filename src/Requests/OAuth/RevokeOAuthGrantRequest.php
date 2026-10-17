<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\OAuth;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Revoke an OAuth grant
 *
 * DELETE /oauth/grants/{oauth_grant_id}
 *
 * @generated from the Resend OpenAPI spec (oauth/revoke-grant). Do not edit by hand, run `composer generate` instead.
 */
class RevokeOAuthGrantRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $oauthGrantId  The OAuth grant ID.
     */
    public function __construct(
        public readonly string $oauthGrantId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/oauth/grants/'.rawurlencode($this->oauthGrantId);
    }
}
