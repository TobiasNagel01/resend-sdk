<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (inboxes/list-drafts, inboxes/get-draft). Do not edit by hand, run `composer generate` instead.
 */
final readonly class InboxDraft
{
    /**
     * @param  string  $id  The ID of the draft.
     * @param  'standalone'|'reply'  $type  `reply` when the draft replies to an email in an existing thread. `standalone` when the draft starts a new thread.
     * @param  list<string>|null  $to  The recipients. `null` or empty when no recipients are set.
     * @param  list<string>  $cc  The CC recipients.
     * @param  list<string>  $bcc  The BCC recipients.
     * @param  string|null  $subject  The subject.
     * @param  string|null  $threadId  The Thread ID when the draft is a reply. `null` otherwise.
     * @param  string|null  $replyToEmailId  The Email ID the draft replies to. `null` otherwise.
     * @param  string  $updatedAt  Timestamp when the draft was last saved.
     * @param  list<array{id: string, filename: string, content_type: string, size: int}>  $attachments  The files stored on the draft.
     * @param  string|null  $snippet  A short preview of the body.
     * @param  string|null  $object  The object type.
     * @param  string|null  $html  The HTML body.
     * @param  string|null  $text  The plain text body. A reply draft created without a body has an empty string.
     * @param  string|null  $emailId  The ID of the outbound email queued when the draft was sent. `null` until the draft is sent.
     * @param  string|null  $createdAt  Timestamp when the draft was created.
     */
    public function __construct(
        public string $id,
        public string $type,
        public ?array $to,
        public array $cc,
        public array $bcc,
        public ?string $subject,
        public ?string $threadId,
        public ?string $replyToEmailId,
        public string $updatedAt,
        public array $attachments,
        public ?string $snippet = null,
        public ?string $object = null,
        public ?string $html = null,
        public ?string $text = null,
        public ?string $emailId = null,
        public ?string $createdAt = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            type: $data['type'],
            to: $data['to'],
            cc: $data['cc'],
            bcc: $data['bcc'],
            subject: $data['subject'],
            threadId: $data['thread_id'],
            replyToEmailId: $data['reply_to_email_id'],
            updatedAt: $data['updated_at'],
            attachments: $data['attachments'],
            snippet: $data['snippet'] ?? null,
            object: $data['object'] ?? null,
            html: $data['html'] ?? null,
            text: $data['text'] ?? null,
            emailId: $data['email_id'] ?? null,
            createdAt: $data['created_at'] ?? null,
        );
    }
}
