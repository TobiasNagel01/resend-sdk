<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Omit;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Send a draft
 *
 * Sends the draft from the inbox address. A reply draft is sent in its thread. A draft without a thread starts a new thread. The draft must have at least one `to` recipient and `html` or `text`, or the request returns a 422. A standalone draft also needs a non-empty `subject`. A reply draft with an empty `subject` is sent with the thread subject, prefixed with `Re:` when it does not already start with it. A draft that was already sent returns a 409. The request body is optional and takes only `headers`. The whole email, encoded, can be at most 40 MB, or the request returns a 422.
 *
 * POST /inboxes/{inbox_id}/drafts/{draft_id}/send
 *
 * @generated from the Resend OpenAPI spec (inboxes/send-draft). Do not edit by hand, run `composer generate` instead.
 */
class SendInboxDraftRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $draftId  The Draft ID.
     * @param  array<string, mixed>|null|Omit  $customHeaders  Custom headers to add to the email. The `In-Reply-To`, `References` and `Reply-To` headers are set by Resend and cannot be set here. Sending one of them, in any letter case, returns a 422. Header names cannot be empty, and names and values cannot contain line breaks or null characters, or the request returns a 422. `null` means no custom headers.
     * @param  string|null  $idempotencyKey  A unique key for the request, so the draft is sent only once. A retry with the same key within 24 hours returns the first successful (2xx) response, with the `idempotent-replayed: true` header. A failed request is not stored, so it can be retried with the same key. Reusing the key with a different body, or while the first request is still running, returns a 409. An empty key, or one longer than 256 characters, returns a 400 `invalid_idempotency_key`. Learn more: https://resend.com/docs/dashboard/emails/idempotency-keys
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $draftId,
        public readonly array|Omit|null $customHeaders = Omit::Value,
        public readonly ?string $idempotencyKey = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/drafts/'.rawurlencode($this->draftId).'/send';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'headers' => $this->customHeaders,
        ], nullable: ['headers']);
    }

    protected function defaultHeaders(): array
    {
        return Payload::headers([
            'Idempotency-Key' => $this->idempotencyKey,
        ]);
    }
}
