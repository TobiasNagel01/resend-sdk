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
 * Forward a thread email
 *
 * Forwards a message from the inbox address right away, with no stored draft. The original message is quoted under a forwarded-message banner, below the optional `html` or `text` note. The attachments of the original message are sent with the forward, together with any `attachments` you add. The request returns a 422 when they exceed 25 MB of `content` in total. An original attachment that was sent from a URL (`path`) cannot be forwarded, and the request returns a 422. The whole email, encoded, can be at most 40 MB, or the request returns a 422.
 *
 * POST /inboxes/{inbox_id}/threads/{thread_id}/emails/{email_id}/forward
 *
 * @generated from the Resend OpenAPI spec (inboxes/forward-thread-email). Do not edit by hand, run `composer generate` instead.
 */
class ForwardInboxThreadEmailRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  string  $emailId  The Email ID of the message to forward, as returned in `data[].id` by the list thread emails endpoint.
     * @param  string|list<string>  $to  Recipient email address. For multiple addresses, send as an array of strings. Must name at least one address. `to`, `cc` and `bcc` combined cannot exceed 50 recipients. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $cc  CC recipient email address. For multiple addresses, send as an array of strings. Counts toward the 50-recipient limit. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $bcc  BCC recipient email address. For multiple addresses, send as an array of strings. Counts toward the 50-recipient limit. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|null  $html  An HTML note sent above the quoted original.
     * @param  string|null  $text  A plain-text note sent above the quoted original.
     * @param  string|null  $subject  The subject of the forward. Cannot be only whitespace or contain a line break. When omitted, the thread subject is used, prefixed with `Fwd:` if it does not already start with it.
     * @param  list<array{content?: string, filename?: string, path?: string, content_type?: string, content_id?: string}>|null|Omit  $attachments  Files to attach, as on `POST /emails`. Each one needs `content` or `path`. They share one limit with the attachments of the original message, which the forward also sends. Together they can have at most 25 MB of `content`. A `path` file does not count toward the 25 MB, because it is fetched when the email is sent. An empty file, a blocked file type, a `path` that does not start with `http` or that starts with `http://localhost:`, or a `content_type` that is not a valid MIME type returns a 422. Other `path` problems fail the email when it is sent, not the request.
     * @param  array<string, mixed>|null|Omit  $customHeaders  Custom headers to add to the email. The `In-Reply-To`, `References` and `Reply-To` headers are set by Resend and cannot be set here. Sending one of them, in any letter case, returns a 422. Header names cannot be empty, and names and values cannot contain line breaks or null characters, or the request returns a 422. `null` means no custom headers.
     * @param  string|null  $idempotencyKey  A unique key for the request, so the forward is sent only once. A retry with the same key within 24 hours returns the first successful (2xx) response, with the `idempotent-replayed: true` header. A failed request is not stored, so it can be retried with the same key. Reusing the key with a different body, or while the first request is still running, returns a 409. An empty key, or one longer than 256 characters, returns a 400 `invalid_idempotency_key`. Learn more: https://resend.com/docs/dashboard/emails/idempotency-keys
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $threadId,
        public readonly string $emailId,
        public readonly string|array $to,
        public readonly string|array|Omit|null $cc = Omit::Value,
        public readonly string|array|Omit|null $bcc = Omit::Value,
        public readonly ?string $html = null,
        public readonly ?string $text = null,
        public readonly ?string $subject = null,
        public readonly array|Omit|null $attachments = Omit::Value,
        public readonly array|Omit|null $customHeaders = Omit::Value,
        public readonly ?string $idempotencyKey = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/threads/'.rawurlencode($this->threadId).'/emails/'.rawurlencode($this->emailId).'/forward';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'to' => $this->to,
            'cc' => $this->cc,
            'bcc' => $this->bcc,
            'html' => $this->html,
            'text' => $this->text,
            'subject' => $this->subject,
            'attachments' => $this->attachments,
            'headers' => $this->customHeaders,
        ], nullable: ['cc', 'bcc', 'attachments', 'headers']);
    }

    protected function defaultHeaders(): array
    {
        return Payload::headers([
            'Idempotency-Key' => $this->idempotencyKey,
        ]);
    }
}
