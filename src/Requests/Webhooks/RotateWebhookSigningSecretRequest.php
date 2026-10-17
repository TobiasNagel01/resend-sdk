<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Rotate a webhook signing secret
 *
 * Generates a new signing secret for the webhook and returns it. Payloads delivered after the rotation are signed with the new secret. The previous secret keeps verifying payloads for 24 hours, so both secrets are accepted during that window. A webhook that does not exist or was removed returns a 404 not_found.
 *
 * POST /webhooks/{webhook_id}/signing-secret/rotate
 *
 * @generated from the Resend OpenAPI spec (webhooks/rotate-signing-secret). Do not edit by hand, run `composer generate` instead.
 */
class RotateWebhookSigningSecretRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $webhookId  The Webhook ID.
     */
    public function __construct(
        public readonly string $webhookId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/webhooks/'.rawurlencode($this->webhookId).'/signing-secret/rotate';
    }
}
