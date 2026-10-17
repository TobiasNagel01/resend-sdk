<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\OAuth\ListOAuthGrantsRequest;
use TobiasNagel01\ResendSdk\Requests\OAuth\RevokeOAuthGrantRequest;

/**
 * OAuth endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class OAuth extends BaseResource
{
    /**
     * Retrieve a list of OAuth grants
     *
     * `$response->dto()` returns a ListResponse<OAuthGrant>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function listGrants(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListOAuthGrantsRequest($limit, $after, $before));
    }

    /**
     * Revoke an OAuth grant
     *
     * @param  string  $oauthGrantId  The OAuth grant ID.
     */
    public function revokeGrant(string $oauthGrantId): Response
    {
        return $this->connector->send(new RevokeOAuthGrantRequest($oauthGrantId));
    }
}
