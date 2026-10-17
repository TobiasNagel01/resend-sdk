<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Segments;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an existing segment
 *
 * PATCH /segments/{id}
 *
 * @generated from the Resend OpenAPI spec (segments/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateSegmentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $id  The Segment ID.
     * @param  string  $name  The name of the segment.
     */
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/segments/'.rawurlencode($this->id);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
        ]);
    }
}
