<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Events;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Send an event
 *
 * POST /events/send
 *
 * @generated from the Resend OpenAPI spec (events/send). Do not edit by hand, run `composer generate` instead.
 */
class SendEventRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $event  The name of the event to send.
     * @param  string|null  $contactId  The ID of the contact to associate with this event. Exactly one of `contact_id` or `email` must be provided.
     * @param  string|null  $email  The email address to associate with this event. Exactly one of `contact_id` or `email` must be provided.
     * @param  array<string, mixed>|null  $payload  An optional payload of key/value pairs to include with the event.
     */
    public function __construct(
        public readonly string $event,
        public readonly ?string $contactId = null,
        public readonly ?string $email = null,
        public readonly ?array $payload = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/events/send';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'event' => $this->event,
            'contact_id' => $this->contactId,
            'email' => $this->email,
            'payload' => $this->payload,
        ]);
    }
}
