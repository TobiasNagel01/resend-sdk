<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove an existing webhook
 *
 * DELETE /webhooks/{webhook_id}
 *
 * @generated from the Resend OpenAPI spec (webhooks/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveWebhookRequest extends Request
{
    protected Method $method = Method::DELETE;

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
}
