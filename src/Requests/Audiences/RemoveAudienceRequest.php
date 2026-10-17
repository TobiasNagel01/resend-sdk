<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Audiences;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove an existing audience
 *
 * Deprecated: Use Segments instead. These endpoints still work, but will be removed in the future.
 *
 * @deprecated
 *
 * DELETE /audiences/{id}
 *
 * @generated from the Resend OpenAPI spec (audiences/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveAudienceRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $id  The Audience ID.
     */
    public function __construct(
        public readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/audiences/'.rawurlencode($this->id);
    }
}
