<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove an existing inbox thread
 *
 * Moves the thread to `trash` and schedules it for deletion in 30 days. This is reversible. To restore the thread, update its `folder` to `inbox`, `archive`, or `spam`, which also clears the deletion deadline.
 *
 * DELETE /inboxes/{inbox_id}/threads/{thread_id}
 *
 * @generated from the Resend OpenAPI spec (inboxes/remove-thread). Do not edit by hand, run `composer generate` instead.
 */
class RemoveInboxThreadRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $threadId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/threads/'.rawurlencode($this->threadId);
    }
}
