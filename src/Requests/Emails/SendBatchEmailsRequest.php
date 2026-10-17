<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Emails;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Trigger up to 100 batch emails at once.
 *
 * POST /emails/batch
 *
 * @generated from the Resend OpenAPI spec (emails/send-batch). Do not edit by hand, run `composer generate` instead.
 */
class SendBatchEmailsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  list<array{from: string, to: string|list<string>, subject: string, bcc?: string|list<string>, cc?: string|list<string>, reply_to?: string|list<string>, html?: string, text?: string, template?: array{id: string, variables?: array<string, mixed>}, headers?: array<string, mixed>, scheduled_at?: string, attachments?: list<array{content?: string, filename?: string, path?: string, content_type?: string, content_id?: string}>, tags?: list<array{name?: string, value?: string}>, topic_id?: string}>  $emails  The items to send.
     * @param  string|null  $idempotencyKey  A unique identifier for the request to ensure emails are only sent once. Learn more: https://resend.com/docs/dashboard/emails/idempotency-keys
     */
    public function __construct(
        public readonly array $emails,
        public readonly ?string $idempotencyKey = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/emails/batch';
    }

    protected function defaultBody(): array
    {
        return $this->emails;
    }

    protected function defaultHeaders(): array
    {
        return Payload::headers([
            'Idempotency-Key' => $this->idempotencyKey,
        ]);
    }
}
