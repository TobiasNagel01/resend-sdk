<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Events\CreateEventRequest;
use TobiasNagel01\ResendSdk\Requests\Events\GetEventRequest;
use TobiasNagel01\ResendSdk\Requests\Events\ListEventsRequest;
use TobiasNagel01\ResendSdk\Requests\Events\RemoveEventRequest;
use TobiasNagel01\ResendSdk\Requests\Events\SendEventRequest;
use TobiasNagel01\ResendSdk\Requests\Events\UpdateEventRequest;
use TobiasNagel01\ResendSdk\Support\Omit;

/**
 * Events endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Events extends BaseResource
{
    /**
     * Create an event
     *
     * @param  string  $name  The name of the event. Cannot start with the reserved `resend:` prefix.
     * @param  array<string, mixed>|null|Omit  $schema  An optional flat key/type map defining the event payload schema. Supported types are `string`, `number`, `boolean`, and `date`.
     */
    public function create(string $name, array|Omit|null $schema = Omit::Value): Response
    {
        return $this->connector->send(new CreateEventRequest($name, $schema));
    }

    /**
     * Retrieve a list of events
     *
     * `$response->dto()` returns a ListResponse<Event>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListEventsRequest($limit, $after, $before));
    }

    /**
     * Send an event
     *
     * @param  string  $event  The name of the event to send.
     * @param  string|null  $contactId  The ID of the contact to associate with this event. Exactly one of `contact_id` or `email` must be provided.
     * @param  string|null  $email  The email address to associate with this event. Exactly one of `contact_id` or `email` must be provided.
     * @param  array<string, mixed>|null  $payload  An optional payload of key/value pairs to include with the event.
     */
    public function send(
        string $event,
        ?string $contactId = null,
        ?string $email = null,
        ?array $payload = null,
    ): Response {
        return $this->connector->send(new SendEventRequest(
            $event,
            $contactId,
            $email,
            $payload,
        ));
    }

    /**
     * Retrieve a single event
     *
     * `$response->dto()` returns an Event.
     *
     * @param  string  $identifier  The event ID (UUID) or event name.
     */
    public function get(string $identifier): Response
    {
        return $this->connector->send(new GetEventRequest($identifier));
    }

    /**
     * Update an event
     *
     * @param  string  $identifier  The event ID (UUID) or event name.
     * @param  array<string, mixed>|null  $schema  A flat key/type map defining the event payload schema. Set to `null` to clear the schema. Supported types are `string`, `number`, `boolean`, and `date`.
     */
    public function update(string $identifier, ?array $schema): Response
    {
        return $this->connector->send(new UpdateEventRequest($identifier, $schema));
    }

    /**
     * Delete an event
     *
     * @param  string  $identifier  The event ID (UUID) or event name.
     */
    public function remove(string $identifier): Response
    {
        return $this->connector->send(new RemoveEventRequest($identifier));
    }
}
