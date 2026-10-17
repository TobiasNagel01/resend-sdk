<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Events;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete an event
 *
 * DELETE /events/{identifier}
 *
 * @generated from the Resend OpenAPI spec (events/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveEventRequest extends Request
{
    protected Method $method = Method::DELETE;

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
}
