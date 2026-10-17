<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an existing inbox thread
 *
 * Marks a thread read or unread, or moves it to a folder. At least one of `read` or `folder` is required. To change the labels of a thread, use the add, set, and remove thread labels endpoints. This endpoint ignores the removed `add_label_ids` and `remove_label_ids` fields, so a body with only those fields returns a 422 validation_error. Moving a thread out of `trash` restores it and clears its deletion deadline. The changes apply in this order: `read`, then `folder`. They are not atomic.
 *
 * PATCH /inboxes/{inbox_id}/threads/{thread_id}
 *
 * @generated from the Resend OpenAPI spec (inboxes/update-thread). Do not edit by hand, run `composer generate` instead.
 */
class UpdateInboxThreadRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  bool|null  $read  Marks every email in the thread read or unread.
     * @param  'inbox'|'archive'|'spam'|'trash'|null  $folder  Moves the thread to this folder. `sent` is assigned automatically and cannot be set.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $threadId,
        public readonly ?bool $read = null,
        public readonly ?string $folder = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/threads/'.rawurlencode($this->threadId);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'read' => $this->read,
            'folder' => $this->folder,
        ]);
    }
}
