<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Suppressions;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Data\Suppression;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of suppressions
 *
 * GET /suppressions
 *
 * @generated from the Resend OpenAPI spec (suppressions/list). Do not edit by hand, run `composer generate` instead.
 */
class ListSuppressionsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  'bounce'|'complaint'|'manual'|null  $origin  Filter suppressions by origin.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function __construct(
        public readonly ?string $origin = null,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/suppressions';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'origin' => $this->origin,
            'limit' => $this->limit,
            'after' => $this->after,
            'before' => $this->before,
        ]);
    }

    /**
     * @return ListResponse<Suppression>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), Suppression::fromArray(...));
    }
}
