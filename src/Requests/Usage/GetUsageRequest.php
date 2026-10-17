<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Usage;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Retrieve account usage
 *
 * Retrieve your account's current usage and plan limits.
 *
 * GET /usage
 *
 * @generated from the Resend OpenAPI spec (usage/get). Do not edit by hand, run `composer generate` instead.
 */
class GetUsageRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/usage';
    }
}
