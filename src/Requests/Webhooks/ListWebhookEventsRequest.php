<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Data\WebhookEvent;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of webhook events
 *
 * GET /webhooks/{webhook_id}/events
 *
 * @generated from the Resend OpenAPI spec (webhooks/list-events). Do not edit by hand, run `composer generate` instead.
 */
class ListWebhookEventsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $webhookId  The Webhook ID.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     */
    public function __construct(
        public readonly string $webhookId,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/webhooks/'.rawurlencode($this->webhookId).'/events';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'limit' => $this->limit,
            'after' => $this->after,
        ]);
    }

    /**
     * @return ListResponse<WebhookEvent>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), WebhookEvent::fromArray(...));
    }
}
