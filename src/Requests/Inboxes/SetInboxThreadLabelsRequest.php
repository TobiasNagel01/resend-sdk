<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Set the labels of an inbox thread
 *
 * Replaces every label on the thread with the given labels, in one atomic change. Labels on the thread that are not in the list are taken off it. The labels themselves are kept. An empty array takes every label off the thread. The response lists every label on the thread after the change. A label ID that is not a label of the inbox returns a 404 `Label not found.`, and nothing changes. A thread that does not exist in the inbox returns a 404 `Thread not found.`.
 *
 * PUT /inboxes/{inbox_id}/threads/{thread_id}/labels
 *
 * @generated from the Resend OpenAPI spec (inboxes/set-thread-labels). Do not edit by hand, run `composer generate` instead.
 */
class SetInboxThreadLabelsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  list<string>  $labels  The IDs of the labels the thread carries after the change. Up to 100 IDs, each a label of the inbox. Pass an empty array to take every label off the thread.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $threadId,
        public readonly array $labels,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/threads/'.rawurlencode($this->threadId).'/labels';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'labels' => $this->labels,
        ]);
    }
}
