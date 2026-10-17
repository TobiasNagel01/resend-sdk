<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Replay a webhook event
 *
 * Queues one more delivery of the event to the webhook. The event must be retrievable through the get event endpoint and the webhook must be enabled; a disabled webhook returns a 422 validation_error. A manual replay does not schedule automatic retries.
 *
 * POST /webhooks/{webhook_id}/events/{event_id}/replay
 *
 * @generated from the Resend OpenAPI spec (webhooks/replay-event). Do not edit by hand, run `composer generate` instead.
 */
class ReplayWebhookEventRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $webhookId  The Webhook ID.
     * @param  string  $eventId  The Webhook Event ID.
     */
    public function __construct(
        public readonly string $webhookId,
        public readonly string $eventId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/webhooks/'.rawurlencode($this->webhookId).'/events/'.rawurlencode($this->eventId).'/replay';
    }
}
