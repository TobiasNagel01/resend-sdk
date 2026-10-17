<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Segments;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a new segment
 *
 * POST /segments
 *
 * @generated from the Resend OpenAPI spec (segments/create). Do not edit by hand, run `composer generate` instead.
 */
class CreateSegmentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $name  The name of the segment.
     * @param  string|null  $audienceId  The ID of the audience this segment belongs to.
     * @param  array<string, mixed>|null  $filter  Filter conditions for the segment.
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $audienceId = null,
        public readonly ?array $filter = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/segments';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'audience_id' => $this->audienceId,
            'filter' => $this->filter,
        ]);
    }
}
