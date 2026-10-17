<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (emails/list, emails/get, emails/cancel). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Email
{
    /**
     * @param  string|null  $object  The type of object.
     * @param  string|null  $id  The ID of the email.
     * @param  string|null  $messageId  The Message-ID header value of the email.
     * @param  list<string>|null  $to
     * @param  string|null  $from  The email address of the sender.
     * @param  string|null  $createdAt  The date and time the email was created.
     * @param  string|null  $subject  The subject line of the email.
     * @param  string|null  $html  The HTML body of the email.
     * @param  string|null  $text  The plain text body of the email.
     * @param  list<string>|null  $bcc  The email addresses of the blind carbon copy recipients.
     * @param  list<string>|null  $cc  The email addresses of the carbon copy recipients.
     * @param  list<string>|null  $replyTo  The email addresses to which replies should be sent.
     * @param  'bounced'|'canceled'|'clicked'|'complained'|'delivered'|'delivery_delayed'|'failed'|'opened'|'queued'|'scheduled'|'sent'|'suppressed'|null  $lastEvent  The status of the email.
     */
    public function __construct(
        public ?string $object = null,
        public ?string $id = null,
        public ?string $messageId = null,
        public ?array $to = null,
        public ?string $from = null,
        public ?string $createdAt = null,
        public ?string $subject = null,
        public ?string $html = null,
        public ?string $text = null,
        public ?array $bcc = null,
        public ?array $cc = null,
        public ?array $replyTo = null,
        public ?string $lastEvent = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            object: $data['object'] ?? null,
            id: $data['id'] ?? null,
            messageId: $data['message_id'] ?? null,
            to: $data['to'] ?? null,
            from: $data['from'] ?? null,
            createdAt: $data['created_at'] ?? null,
            subject: $data['subject'] ?? null,
            html: $data['html'] ?? null,
            text: $data['text'] ?? null,
            bcc: $data['bcc'] ?? null,
            cc: $data['cc'] ?? null,
            replyTo: $data['reply_to'] ?? null,
            lastEvent: $data['last_event'] ?? null,
        );
    }
}
