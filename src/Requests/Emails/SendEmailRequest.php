<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Emails;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Send an email
 *
 * POST /emails
 *
 * @generated from the Resend OpenAPI spec (emails/send). Do not edit by hand, run `composer generate` instead.
 */
class SendEmailRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $from  Sender email address. To include a friendly name, use the format "Your Name <sender@domain.com>".
     * @param  string|list<string>  $to  Recipient email address. For multiple addresses, send as an array of strings. Max 50.
     * @param  string  $subject  Email subject.
     * @param  string|list<string>|null  $bcc  Bcc recipient email address. For multiple addresses, send as an array of strings.
     * @param  string|list<string>|null  $cc  Cc recipient email address. For multiple addresses, send as an array of strings.
     * @param  string|list<string>|null  $replyTo  Reply-to email address. For multiple addresses, send as an array of strings.
     * @param  string|null  $html  The HTML version of the message.
     * @param  string|null  $text  The plain text version of the message.
     * @param  array{id: string, variables?: array<string, mixed>}|null  $template  Use a published template to send the email. If provided, do not include html or text.
     * @param  array<string, mixed>|null  $customHeaders  Custom headers to add to the email.
     * @param  string|null  $scheduledAt  Schedule email to be sent later. The date should be in ISO 8601 format.
     * @param  list<array{content?: string, filename?: string, path?: string, content_type?: string, content_id?: string}>|null  $attachments
     * @param  list<array{name?: string, value?: string}>|null  $tags
     * @param  string|null  $topicId  The topic ID to scope the email to. If the recipient is a contact and opted-in to the topic, the email is sent. If opted-out, the email is not sent. If the recipient is not a contact, the email is sent if the topic's default subscription is opt_in.
     * @param  string|null  $idempotencyKey  A unique identifier for the request to ensure emails are only sent once. Learn more: https://resend.com/docs/dashboard/emails/idempotency-keys
     */
    public function __construct(
        public readonly string $from,
        public readonly string|array $to,
        public readonly string $subject,
        public readonly string|array|null $bcc = null,
        public readonly string|array|null $cc = null,
        public readonly string|array|null $replyTo = null,
        public readonly ?string $html = null,
        public readonly ?string $text = null,
        public readonly ?array $template = null,
        public readonly ?array $customHeaders = null,
        public readonly ?string $scheduledAt = null,
        public readonly ?array $attachments = null,
        public readonly ?array $tags = null,
        public readonly ?string $topicId = null,
        public readonly ?string $idempotencyKey = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/emails';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'from' => $this->from,
            'to' => $this->to,
            'subject' => $this->subject,
            'bcc' => $this->bcc,
            'cc' => $this->cc,
            'reply_to' => $this->replyTo,
            'html' => $this->html,
            'text' => $this->text,
            'template' => $this->template,
            'headers' => $this->customHeaders,
            'scheduled_at' => $this->scheduledAt,
            'attachments' => $this->attachments,
            'tags' => $this->tags,
            'topic_id' => $this->topicId,
        ]);
    }

    protected function defaultHeaders(): array
    {
        return Payload::headers([
            'Idempotency-Key' => $this->idempotencyKey,
        ]);
    }
}
