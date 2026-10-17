<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Broadcasts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Send or schedule a broadcast
 *
 * POST /broadcasts/{id}/send
 *
 * @generated from the Resend OpenAPI spec (broadcasts/send). Do not edit by hand, run `composer generate` instead.
 */
class SendBroadcastRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $id  The Broadcast ID.
     * @param  string|null  $scheduledAt  Schedule email to be sent later. The date should be in ISO 8601 format.
     */
    public function __construct(
        public readonly string $id,
        public readonly ?string $scheduledAt = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/broadcasts/'.rawurlencode($this->id).'/send';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'scheduled_at' => $this->scheduledAt,
        ]);
    }
}
