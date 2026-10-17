<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Segments;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove an existing segment
 *
 * DELETE /segments/{id}
 *
 * @generated from the Resend OpenAPI spec (segments/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveSegmentRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $id  The Segment ID.
     */
    public function __construct(
        public readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/segments/'.rawurlencode($this->id);
    }
}
