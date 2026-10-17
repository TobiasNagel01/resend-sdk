<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Events;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an event
 *
 * PATCH /events/{identifier}
 *
 * @generated from the Resend OpenAPI spec (events/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateEventRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $identifier  The event ID (UUID) or event name.
     * @param  array<string, mixed>|null  $schema  A flat key/type map defining the event payload schema. Set to `null` to clear the schema. Supported types are `string`, `number`, `boolean`, and `date`.
     */
    public function __construct(
        public readonly string $identifier,
        public readonly ?array $schema,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/events/'.rawurlencode($this->identifier);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'schema' => $this->schema,
        ], nullable: ['schema']);
    }
}
