<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\InboxThreadEmail;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of thread emails
 *
 * Returns the messages of a thread, oldest first. Pass the `id` of the last message as `after` to get the next, newer page. Pass the `id` of the first message as `before` to get the previous, older page. Passing both `after` and `before`, or a cursor that is not a UUID, returns a 422. A cursor that is not a message of the thread returns a 404.
 *
 * GET /inboxes/{inbox_id}/threads/{thread_id}/emails
 *
 * @generated from the Resend OpenAPI spec (inboxes/list-thread-emails). Do not edit by hand, run `composer generate` instead.
 */
class ListInboxThreadEmailsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $threadId,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/threads/'.rawurlencode($this->threadId).'/emails';
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
     * @return ListResponse<InboxThreadEmail>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), InboxThreadEmail::fromArray(...));
    }
}
