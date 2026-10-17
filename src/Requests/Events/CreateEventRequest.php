<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Events;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Omit;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create an event
 *
 * POST /events
 *
 * @generated from the Resend OpenAPI spec (events/create). Do not edit by hand, run `composer generate` instead.
 */
class CreateEventRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $name  The name of the event. Cannot start with the reserved `resend:` prefix.
     * @param  array<string, mixed>|null|Omit  $schema  An optional flat key/type map defining the event payload schema. Supported types are `string`, `number`, `boolean`, and `date`.
     */
    public function __construct(
        public readonly string $name,
        public readonly array|Omit|null $schema = Omit::Value,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/events';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'schema' => $this->schema,
        ], nullable: ['schema']);
    }
}
