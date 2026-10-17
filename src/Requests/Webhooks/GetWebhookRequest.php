<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Webhook;

/**
 * Retrieve a single webhook
 *
 * GET /webhooks/{webhook_id}
 *
 * @generated from the Resend OpenAPI spec (webhooks/get). Do not edit by hand, run `composer generate` instead.
 */
class GetWebhookRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $webhookId  The Webhook ID.
     */
    public function __construct(
        public readonly string $webhookId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/webhooks/'.rawurlencode($this->webhookId);
    }

    public function createDtoFromResponse(Response $response): Webhook
    {
        return Webhook::fromArray($response->json());
    }
}
