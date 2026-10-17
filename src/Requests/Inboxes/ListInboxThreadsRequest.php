<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\InboxThread;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of inbox threads
 *
 * Returns the threads in an inbox, most recently active first. A thread is a conversation made up of one or more emails. The `after` and `before` cursors take a thread ID, and only one of them can be passed. A cursor that is not a UUID, such as a date, returns a 422 validation_error. A cursor thread that is not in the selected folders returns a 404. To find threads by text, sender, recipient, attachment, or date, use the search threads endpoint.
 *
 * GET /inboxes/{inbox_id}/threads
 *
 * @generated from the Resend OpenAPI spec (inboxes/list-threads). Do not edit by hand, run `composer generate` instead.
 */
class ListInboxThreadsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  list<'inbox'|'archive'|'spam'|'sent'|'trash'>|null  $folders  Comma-separated folders to list, for example `inbox,sent`. Repeating the parameter returns a 422 validation_error. A thread is returned when any of its emails is in one of the folders, so a thread in `inbox` with an email you sent matches both `inbox` and `sent`. Defaults to `inbox`, or to `inbox,archive,sent` when `labels` is set. `spam` and `trash` are only included when you name them.
     * @param  list<string>|null  $labels  Comma-separated label IDs. Returns threads with any of these labels. Up to 50 IDs. An ID that does not exist in the inbox returns a 404. Repeating the parameter returns a 422 validation_error.
     * @param  bool|null  $read  `true` returns threads where every email is read. `false` returns threads with at least one unread email. Only the literal values `true` and `false` are accepted.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly ?array $folders = null,
        public readonly ?array $labels = null,
        public readonly ?bool $read = null,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/threads';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'folders' => $this->folders,
            'labels' => $this->labels,
            'read' => $this->read,
            'limit' => $this->limit,
            'after' => $this->after,
            'before' => $this->before,
        ]);
    }

    /**
     * @return ListResponse<InboxThread>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), InboxThread::fromArray(...));
    }
}
