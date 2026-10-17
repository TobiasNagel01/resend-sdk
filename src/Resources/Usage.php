<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Usage\GetUsageRequest;

/**
 * Usage endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Usage extends BaseResource
{
    /**
     * Retrieve account usage
     */
    public function get(): Response
    {
        return $this->connector->send(new GetUsageRequest);
    }
}
