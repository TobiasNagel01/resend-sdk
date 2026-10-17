<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Webhooks;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an existing webhook
 *
 * PATCH /webhooks/{webhook_id}
 *
 * @generated from the Resend OpenAPI spec (webhooks/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateWebhookRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $webhookId  The Webhook ID.
     * @param  string|null  $endpoint  The URL where webhook events will be sent.
     * @param  list<string>|null  $events  Array of event types to subscribe to.
     * @param  'enabled'|'disabled'|null  $status  The status of the webhook.
     */
    public function __construct(
        public readonly string $webhookId,
        public readonly ?string $endpoint = null,
        public readonly ?array $events = null,
        public readonly ?string $status = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/webhooks/'.rawurlencode($this->webhookId);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'endpoint' => $this->endpoint,
            'events' => $this->events,
            'status' => $this->status,
        ]);
    }
}
