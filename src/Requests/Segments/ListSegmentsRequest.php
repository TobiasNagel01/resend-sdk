<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Segments;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Data\Segment;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of segments
 *
 * GET /segments
 *
 * @generated from the Resend OpenAPI spec (segments/list). Do not edit by hand, run `composer generate` instead.
 */
class ListSegmentsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function __construct(
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/segments';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'limit' => $this->limit,
            'after' => $this->after,
            'before' => $this->before,
        ]);
    }

    /**
     * @return ListResponse<Segment>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), Segment::fromArray(...));
    }
}
