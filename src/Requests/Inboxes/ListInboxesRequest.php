<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Inbox;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of inboxes
 *
 * Returns the inboxes of the team, newest first. The list items carry fewer fields than a single inbox. Retrieve an inbox to get all its fields. The `after` and `before` cursors take an inbox ID, and only one of them can be passed, or the request returns a 422. A value that is not a UUID returns a 422, and an unknown ID returns a 404.
 *
 * GET /inboxes
 *
 * @generated from the Resend OpenAPI spec (inboxes/list). Do not edit by hand, run `composer generate` instead.
 */
class ListInboxesRequest extends Request
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
        return '/inboxes';
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
     * @return ListResponse<Inbox>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), Inbox::fromArray(...));
    }
}
