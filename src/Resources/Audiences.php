<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Audiences\CreateAudienceRequest;
use TobiasNagel01\ResendSdk\Requests\Audiences\GetAudienceRequest;
use TobiasNagel01\ResendSdk\Requests\Audiences\ListAudiencesRequest;
use TobiasNagel01\ResendSdk\Requests\Audiences\RemoveAudienceRequest;

/**
 * Audiences endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Audiences extends BaseResource
{
    /**
     * Create a list of contacts
     *
     * @deprecated
     *
     * @param  string  $name  The name of the audience you want to create.
     */
    public function create(string $name): Response
    {
        return $this->connector->send(new CreateAudienceRequest($name));
    }

    /**
     * Retrieve a list of audiences
     *
     * `$response->dto()` returns a ListResponse<Audience>.
     *
     * @deprecated
     */
    public function list(): Response
    {
        return $this->connector->send(new ListAudiencesRequest);
    }

    /**
     * Remove an existing audience
     *
     * @deprecated
     *
     * @param  string  $id  The Audience ID.
     */
    public function remove(string $id): Response
    {
        return $this->connector->send(new RemoveAudienceRequest($id));
    }

    /**
     * Retrieve a single audience
     *
     * `$response->dto()` returns an Audience.
     *
     * @deprecated
     *
     * @param  string  $id  The Audience ID.
     */
    public function get(string $id): Response
    {
        return $this->connector->send(new GetAudienceRequest($id));
    }
}
