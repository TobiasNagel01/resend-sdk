<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (inboxes/list-thread-emails, inboxes/get-thread-email). Do not edit by hand, run `composer generate` instead.
 */
final readonly class InboxThreadEmail
{
    /**
     * @param  string  $id  The ID of the message.
     * @param  'inbound'|'outbound'  $direction  Whether the inbox received the message (`inbound`) or sent it (`outbound`). A message the inbox sent to itself is `inbound`, so a reply to it goes to its sender.
     * @param  string  $from  Sender email address. Includes the display name when the sender has one, in the format "Name <sender@domain.com>".
     * @param  list<string>  $to  The recipients of the message. For a received message, these are the addresses it was delivered to, not the full `To` header.
     * @param  list<string>  $cc  The CC recipients of the message.
     * @param  list<string>  $bcc  The BCC recipients of the message. Always empty for a received message.
     * @param  list<string>  $replyTo  The Reply-To addresses of the message.
     * @param  string|null  $subject  The subject of the message.
     * @param  string|null  $messageId  The Message-ID header of the message.
     * @param  string|null  $html  The HTML body.
     * @param  string|null  $text  The plain-text body.
     * @param  list<array{id: string, filename: string, size: int}>  $attachments  The attachments of the message.
     * @param  bool  $read  Whether the message has been read.
     * @param  string  $receivedAt  Timestamp when the inbox received the message, or when the inbox sent it.
     */
    public function __construct(
        public string $id,
        public string $direction,
        public string $from,
        public array $to,
        public array $cc,
        public array $bcc,
        public array $replyTo,
        public ?string $subject,
        public ?string $messageId,
        public ?string $html,
        public ?string $text,
        public array $attachments,
        public bool $read,
        public string $receivedAt,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            direction: $data['direction'],
            from: $data['from'],
            to: $data['to'],
            cc: $data['cc'],
            bcc: $data['bcc'],
            replyTo: $data['reply_to'],
            subject: $data['subject'],
            messageId: $data['message_id'],
            html: $data['html'],
            text: $data['text'],
            attachments: $data['attachments'],
            read: $data['read'],
            receivedAt: $data['received_at'],
        );
    }
}
