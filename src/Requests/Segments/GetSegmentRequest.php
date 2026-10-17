<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Segments;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Segment;

/**
 * Retrieve a single segment
 *
 * GET /segments/{id}
 *
 * @generated from the Resend OpenAPI spec (segments/get). Do not edit by hand, run `composer generate` instead.
 */
class GetSegmentRequest extends Request
{
    protected Method $method = Method::GET;

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

    public function createDtoFromResponse(Response $response): Segment
    {
        return Segment::fromArray($response->json());
    }
}
