<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\WebhookEvent;

/**
 * Retrieve a single webhook event
 *
 * GET /webhooks/{webhook_id}/events/{event_id}
 *
 * @generated from the Resend OpenAPI spec (webhooks/get-event). Do not edit by hand, run `composer generate` instead.
 */
class GetWebhookEventRequest extends Request
{
    protected Method $method = Method::GET;

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
        return '/webhooks/'.rawurlencode($this->webhookId).'/events/'.rawurlencode($this->eventId);
    }

    public function createDtoFromResponse(Response $response): WebhookEvent
    {
        return WebhookEvent::fromArray($response->json());
    }
}
