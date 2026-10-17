<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Events;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Event;

/**
 * Retrieve a single event
 *
 * GET /events/{identifier}
 *
 * @generated from the Resend OpenAPI spec (events/get). Do not edit by hand, run `composer generate` instead.
 */
class GetEventRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $identifier  The event ID (UUID) or event name.
     */
    public function __construct(
        public readonly string $identifier,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/events/'.rawurlencode($this->identifier);
    }

    public function createDtoFromResponse(Response $response): Event
    {
        return Event::fromArray($response->json());
    }
}
