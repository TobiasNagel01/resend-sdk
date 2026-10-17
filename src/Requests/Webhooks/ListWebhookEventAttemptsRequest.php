<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of webhook event attempts
 *
 * GET /webhooks/{webhook_id}/events/{event_id}/attempts
 *
 * @generated from the Resend OpenAPI spec (webhooks/list-event-attempts). Do not edit by hand, run `composer generate` instead.
 */
class ListWebhookEventAttemptsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $webhookId  The Webhook ID.
     * @param  string  $eventId  The Webhook Event ID.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     */
    public function __construct(
        public readonly string $webhookId,
        public readonly string $eventId,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/webhooks/'.rawurlencode($this->webhookId).'/events/'.rawurlencode($this->eventId).'/attempts';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'limit' => $this->limit,
            'after' => $this->after,
        ]);
    }
}
