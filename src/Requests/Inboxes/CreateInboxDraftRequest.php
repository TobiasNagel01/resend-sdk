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
 * Create a draft
 *
 * Creates an unsent draft on the inbox. Omit `thread_id` and `reply_to_email_id` for a draft that starts a new thread. Pass both together for a reply draft in an existing thread. A reply draft without `to` is addressed to the sender of the email it replies to, or to its Reply-To when set. For an email the inbox sent, it defaults to that email's `to` recipients. Send `to: []` to leave it empty. At least one of `to`, `cc`, `bcc`, `subject`, `text`, `html` or `attachments` must be non-empty. The combined recipients of `to`, `cc` and `bcc` cannot exceed 50. Attachments are stored on the draft, so each one needs `content`, `filename` and `content_type`. Returns 201 for a new draft. Only one unsent reply draft can target an email, so a reply draft request for an email that already has one returns 200 with the ID of the existing draft. An unknown `thread_id`, or a `reply_to_email_id` that is not in that thread, returns a 404. That request ignores every other field, except `attachments`, which replaces the attachments of the existing draft when sent. A reply draft created without `subject` stores an empty subject. When it is sent, it takes the thread subject, prefixed with `Re:` when it does not already start with it.
 *
 * POST /inboxes/{inbox_id}/drafts
 *
 * @generated from the Resend OpenAPI spec (inboxes/create-draft). Do not edit by hand, run `composer generate` instead.
 */
class CreateInboxDraftRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string|list<string>|null|Omit  $to  The recipients. For multiple addresses, send an array of strings. Each value can include a friendly name, for example `Ada Lovelace <ada@example.org>`. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $cc  The CC recipients. For multiple addresses, send an array of strings. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $bcc  The BCC recipients. For multiple addresses, send an array of strings. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|null|Omit  $subject  The subject. Max 2000 characters. A string that is only whitespace, or that contains a line break, is rejected.
     * @param  string|null|Omit  $html  The HTML body.
     * @param  string|null|Omit  $text  The plain text body.
     * @param  list<array{content: string, filename: string, content_type: string}>|null|Omit  $attachments  Files to store on the draft. Each one needs `content`, `filename` and `content_type`. A `path` without `content` returns a 422, and when both are sent, `path` is ignored. A `content_id` returns a 422. The files on a draft can total at most 25 MB. An empty file or a blocked file type returns a 422.
     * @param  string|null  $threadId  The Thread ID to reply in. Must be sent with `reply_to_email_id`.
     * @param  string|null  $replyToEmailId  The Email ID to reply to, as returned in `data[].id` by the list thread emails endpoint. Must be sent with `thread_id`.
     * @param  string|null  $idempotencyKey  A unique key for the request, so the draft is created only once. A retry with the same key within 24 hours returns the first successful (2xx) response, with the `idempotent-replayed: true` header. A failed request is not stored, so it can be retried with the same key. Reusing the key with a different body, or while the first request is still running, returns a 409. An empty key, or one longer than 256 characters, returns a 400 `invalid_idempotency_key`. Learn more: https://resend.com/docs/dashboard/emails/idempotency-keys
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string|array|Omit|null $to = Omit::Value,
        public readonly string|array|Omit|null $cc = Omit::Value,
        public readonly string|array|Omit|null $bcc = Omit::Value,
        public readonly string|Omit|null $subject = Omit::Value,
        public readonly string|Omit|null $html = Omit::Value,
        public readonly string|Omit|null $text = Omit::Value,
        public readonly array|Omit|null $attachments = Omit::Value,
        public readonly ?string $threadId = null,
        public readonly ?string $replyToEmailId = null,
        public readonly ?string $idempotencyKey = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/drafts';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'to' => $this->to,
            'cc' => $this->cc,
            'bcc' => $this->bcc,
            'subject' => $this->subject,
            'html' => $this->html,
            'text' => $this->text,
            'attachments' => $this->attachments,
            'thread_id' => $this->threadId,
            'reply_to_email_id' => $this->replyToEmailId,
        ], nullable: ['to', 'cc', 'bcc', 'subject', 'html', 'text', 'attachments']);
    }

    protected function defaultHeaders(): array
    {
        return Payload::headers([
            'Idempotency-Key' => $this->idempotencyKey,
        ]);
    }
}
