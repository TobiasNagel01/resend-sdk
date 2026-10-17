<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove a label from an inbox thread
 *
 * Takes one label off the thread. The label itself is kept, and stays on every other thread that carries it. To delete the label, use the remove inbox label endpoint. The response lists every label on the thread after the change. A label that is not on the thread returns a 200 with the current labels. A label ID that is not a label of the inbox returns a 404 `Label not found.`. A thread that does not exist in the inbox returns a 404 `Thread not found.`.
 *
 * DELETE /inboxes/{inbox_id}/threads/{thread_id}/labels/{label_id}
 *
 * @generated from the Resend OpenAPI spec (inboxes/remove-thread-label). Do not edit by hand, run `composer generate` instead.
 */
class RemoveInboxThreadLabelRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  string  $labelId  The Label ID.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $threadId,
        public readonly string $labelId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/threads/'.rawurlencode($this->threadId).'/labels/'.rawurlencode($this->labelId);
    }
}
