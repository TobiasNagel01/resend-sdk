<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Webhooks;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a new webhook
 *
 * POST /webhooks
 *
 * @generated from the Resend OpenAPI spec (webhooks/create). Do not edit by hand, run `composer generate` instead.
 */
class CreateWebhookRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $endpoint  The URL where webhook events will be sent.
     * @param  list<string>  $events  Array of event types to subscribe to.
     */
    public function __construct(
        public readonly string $endpoint,
        public readonly array $events,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/webhooks';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'endpoint' => $this->endpoint,
            'events' => $this->events,
        ]);
    }
}
