<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Suppressions;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove a single suppression by ID or email
 *
 * DELETE /suppressions/{suppression}
 *
 * @generated from the Resend OpenAPI spec (suppressions/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveSuppressionRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $suppression  The Suppression ID or email address.
     */
    public function __construct(
        public readonly string $suppression,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/suppressions/'.rawurlencode($this->suppression);
    }
}
