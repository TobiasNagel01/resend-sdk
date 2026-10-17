<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\InboxDraft;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of drafts
 *
 * Returns the unsent drafts on the inbox, most recently updated first. The `after` and `before` cursors take a Draft ID from the current page, and only one of them can be passed. A cursor that is not a UUID, or both cursors together, return a 422. A cursor that is not an unsent draft on this inbox returns a 404.
 *
 * GET /inboxes/{inbox_id}/drafts
 *
 * @generated from the Resend OpenAPI spec (inboxes/list-drafts). Do not edit by hand, run `composer generate` instead.
 */
class ListInboxDraftsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/drafts';
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
     * @return ListResponse<InboxDraft>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), InboxDraft::fromArray(...));
    }
}
