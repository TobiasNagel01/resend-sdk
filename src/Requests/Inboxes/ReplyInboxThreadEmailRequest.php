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
 * Reply to a thread email
 *
 * Sends a reply from the inbox address right away, with no stored draft. The `to` recipients come from the message you reply to. For a message the inbox received, the reply goes to its `Reply-To` addresses, or to its sender when it has no `Reply-To`. For a message the inbox sent, the reply goes to that message's `to` recipients. Set `reply_all` to also copy the other recipients of the message. The reply threads under the message through the `In-Reply-To` and `References` headers. When no recipient can be found for the reply, the request returns a 422. The whole email, encoded, can be at most 40 MB, or the request returns a 422.
 *
 * POST /inboxes/{inbox_id}/threads/{thread_id}/emails/{email_id}/reply
 *
 * @generated from the Resend OpenAPI spec (inboxes/reply-thread-email). Do not edit by hand, run `composer generate` instead.
 */
class ReplyInboxThreadEmailRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  string  $emailId  The Email ID of the message to reply to, as returned in `data[].id` by the list thread emails endpoint.
     * @param  string|list<string>|null|Omit  $cc  CC recipient email address. For multiple addresses, send as an array of strings. Without `reply_all`, the reply copies only these addresses. With `reply_all`, these addresses are merged with the copied recipients, without duplicates. `cc` and `bcc` combined must be fewer than 50 addresses. After the `to` recipients are added, the reply cannot exceed 50 recipients. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $bcc  BCC recipient email address. For multiple addresses, send as an array of strings. BCC recipients of the original message are never copied. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|null  $html  The HTML body of the reply.
     * @param  string|null  $text  The plain-text body of the reply.
     * @param  string|null  $subject  The subject of the reply. Cannot be only whitespace or contain a line break. When omitted, the thread subject is used, prefixed with `Re:` if it does not already start with it.
     * @param  bool|null  $replyAll  Reply to everyone on the original message. For a message the inbox received, the reply goes to its `Reply-To` addresses, or to its sender when it has none, and copies the other addresses of its `To` header and its `cc` recipients in `cc`. For a message the inbox sent, the reply goes to that message's `Reply-To` addresses when they are not the inbox address, otherwise to its `to` recipients, and copies its `cc` recipients. The inbox address is always excluded, and duplicates are removed.
     * @param  list<array{content?: string, filename?: string, path?: string, content_type?: string, content_id?: string}>|null|Omit  $attachments  Files to attach, as on `POST /emails`. Each one needs `content` or `path`. The `content` of all files can total at most 25 MB. A `path` file does not count toward the 25 MB, because it is fetched when the email is sent. An empty file, a blocked file type, a `path` that does not start with `http` or that starts with `http://localhost:`, or a `content_type` that is not a valid MIME type returns a 422. Other `path` problems fail the email when it is sent, not the request.
     * @param  array<string, mixed>|null|Omit  $customHeaders  Custom headers to add to the email. The `In-Reply-To`, `References` and `Reply-To` headers are set by Resend and cannot be set here. Sending one of them, in any letter case, returns a 422. Header names cannot be empty, and names and values cannot contain line breaks or null characters, or the request returns a 422. `null` means no custom headers.
     * @param  string|null  $idempotencyKey  A unique key for the request, so the reply is sent only once. A retry with the same key within 24 hours returns the first successful (2xx) response, with the `idempotent-replayed: true` header. A failed request is not stored, so it can be retried with the same key. Reusing the key with a different body, or while the first request is still running, returns a 409. An empty key, or one longer than 256 characters, returns a 400 `invalid_idempotency_key`. Learn more: https://resend.com/docs/dashboard/emails/idempotency-keys
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $threadId,
        public readonly string $emailId,
        public readonly string|array|Omit|null $cc = Omit::Value,
        public readonly string|array|Omit|null $bcc = Omit::Value,
        public readonly ?string $html = null,
        public readonly ?string $text = null,
        public readonly ?string $subject = null,
        public readonly ?bool $replyAll = null,
        public readonly array|Omit|null $attachments = Omit::Value,
        public readonly array|Omit|null $customHeaders = Omit::Value,
        public readonly ?string $idempotencyKey = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/threads/'.rawurlencode($this->threadId).'/emails/'.rawurlencode($this->emailId).'/reply';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'cc' => $this->cc,
            'bcc' => $this->bcc,
            'html' => $this->html,
            'text' => $this->text,
            'subject' => $this->subject,
            'reply_all' => $this->replyAll,
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
