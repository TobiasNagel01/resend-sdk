<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (inboxes/list-threads, inboxes/get-thread). Do not edit by hand, run `composer generate` instead.
 */
final readonly class InboxThread
{
    /**
     * @param  string  $id  The ID of the thread.
     * @param  string|null  $subject  The subject of the thread.
     * @param  list<InboxThreadLabel>  $labels  The labels attached to the thread.
     * @param  bool  $read  True only when every email in the thread is read.
     * @param  'inbox'|'archive'|'spam'|'sent'|'trash'  $folder  The folder the thread is in. Every thread is in exactly one folder. `inbox` holds threads with at least one received email. `archive` and `spam` hold threads moved there. `trash` holds threads scheduled for deletion in 30 days. `sent` holds threads whose emails are all outbound, and is assigned automatically.
     * @param  string|null  $from  The sender email address. Can include the display name.
     * @param  list<string>|null  $to  The recipients of the most recent email. For a received email, these are the addresses it was delivered to, not the full `To` header.
     * @param  list<string>|null  $cc  The CC recipients of the most recent email.
     * @param  list<string>|null  $bcc  The BCC recipients of the most recent email. Always empty for a received email.
     * @param  int|null  $emailCount  The number of emails in the thread.
     * @param  bool|null  $hasAttachment  Whether the most recent email in the thread has an attachment.
     * @param  bool|null  $hasDraft  Whether the thread has an unsent draft.
     * @param  string|null  $receivedAt  Timestamp when the thread was last active.
     * @param  string|null  $object  The object type.
     */
    public function __construct(
        public string $id,
        public ?string $subject,
        public array $labels,
        public bool $read,
        public string $folder,
        public ?string $from = null,
        public ?array $to = null,
        public ?array $cc = null,
        public ?array $bcc = null,
        public ?int $emailCount = null,
        public ?bool $hasAttachment = null,
        public ?bool $hasDraft = null,
        public ?string $receivedAt = null,
        public ?string $object = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            subject: $data['subject'],
            labels: isset($data['labels']) ? array_map(InboxThreadLabel::fromArray(...), $data['labels']) : null,
            read: $data['read'],
            folder: $data['folder'],
            from: $data['from'] ?? null,
            to: $data['to'] ?? null,
            cc: $data['cc'] ?? null,
            bcc: $data['bcc'] ?? null,
            emailCount: $data['email_count'] ?? null,
            hasAttachment: $data['has_attachment'] ?? null,
            hasDraft: $data['has_draft'] ?? null,
            receivedAt: $data['received_at'] ?? null,
            object: $data['object'] ?? null,
        );
    }
}
