<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (emails/list-receiving, emails/get-receiving). Do not edit by hand, run `composer generate` instead.
 */
final readonly class ReceivedEmail
{
    /**
     * @param  string|null  $id  The ID of the received email.
     * @param  list<string>|null  $to  The recipient email addresses.
     * @param  string|null  $from  The sender email address.
     * @param  string|null  $subject  The email subject.
     * @param  string|null  $messageId  The unique message ID from the email headers.
     * @param  list<string>|null  $bcc  The BCC recipients.
     * @param  list<string>|null  $cc  The CC recipients.
     * @param  list<string>|null  $replyTo  The reply-to addresses.
     * @param  string|null  $createdAt  Timestamp when the email was received.
     * @param  list<array{id?: string, filename?: string, content_type?: string, content_id?: string, content_disposition?: 'inline'|'attachment', size?: int}>|null  $attachments  Array of attachments for this email.
     * @param  string|null  $object  The type of object.
     * @param  list<string>|null  $receivedFor  The recipient addresses the email was forwarded for, taken from the `for` clause of the message's `Received` headers.
     * @param  string|null  $html  The HTML content of the email.
     * @param  string|null  $text  The plain text content of the email.
     * @param  array<string, mixed>|null  $headers  The email headers.
     */
    public function __construct(
        public ?string $id = null,
        public ?array $to = null,
        public ?string $from = null,
        public ?string $subject = null,
        public ?string $messageId = null,
        public ?array $bcc = null,
        public ?array $cc = null,
        public ?array $replyTo = null,
        public ?string $createdAt = null,
        public ?array $attachments = null,
        public ?string $object = null,
        public ?array $receivedFor = null,
        public ?string $html = null,
        public ?string $text = null,
        public ?array $headers = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            to: $data['to'] ?? null,
            from: $data['from'] ?? null,
            subject: $data['subject'] ?? null,
            messageId: $data['message_id'] ?? null,
            bcc: $data['bcc'] ?? null,
            cc: $data['cc'] ?? null,
            replyTo: $data['reply_to'] ?? null,
            createdAt: $data['created_at'] ?? null,
            attachments: $data['attachments'] ?? null,
            object: $data['object'] ?? null,
            receivedFor: $data['received_for'] ?? null,
            html: $data['html'] ?? null,
            text: $data['text'] ?? null,
            headers: $data['headers'] ?? null,
        );
    }
}
