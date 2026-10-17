<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Webhooks\CreateWebhookRequest;
use TobiasNagel01\ResendSdk\Requests\Webhooks\GetWebhookEventRequest;
use TobiasNagel01\ResendSdk\Requests\Webhooks\GetWebhookRequest;
use TobiasNagel01\ResendSdk\Requests\Webhooks\ListWebhookEventAttemptsRequest;
use TobiasNagel01\ResendSdk\Requests\Webhooks\ListWebhookEventsRequest;
use TobiasNagel01\ResendSdk\Requests\Webhooks\ListWebhooksRequest;
use TobiasNagel01\ResendSdk\Requests\Webhooks\RemoveWebhookRequest;
use TobiasNagel01\ResendSdk\Requests\Webhooks\ReplayWebhookEventRequest;
use TobiasNagel01\ResendSdk\Requests\Webhooks\RotateWebhookSigningSecretRequest;
use TobiasNagel01\ResendSdk\Requests\Webhooks\UpdateWebhookRequest;

/**
 * Webhooks endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Webhooks extends BaseResource
{
    /**
     * Create a new webhook
     *
     * @param  string  $endpoint  The URL where webhook events will be sent.
     * @param  list<string>  $events  Array of event types to subscribe to.
     */
    public function create(string $endpoint, array $events): Response
    {
        return $this->connector->send(new CreateWebhookRequest($endpoint, $events));
    }

    /**
     * Retrieve a list of webhooks
     *
     * `$response->dto()` returns a ListResponse<Webhook>.
     *
     * @param  int|null  $limit  Maximum number of webhooks to return.
     * @param  string|null  $after  Pagination cursor to fetch results after this webhook ID. Cannot be used with 'before'.
     * @param  string|null  $before  Pagination cursor to fetch results before this webhook ID. Cannot be used with 'after'.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListWebhooksRequest($limit, $after, $before));
    }

    /**
     * Retrieve a single webhook
     *
     * `$response->dto()` returns a Webhook.
     *
     * @param  string  $webhookId  The Webhook ID.
     */
    public function get(string $webhookId): Response
    {
        return $this->connector->send(new GetWebhookRequest($webhookId));
    }

    /**
     * Update an existing webhook
     *
     * @param  string  $webhookId  The Webhook ID.
     * @param  string|null  $endpoint  The URL where webhook events will be sent.
     * @param  list<string>|null  $events  Array of event types to subscribe to.
     * @param  'enabled'|'disabled'|null  $status  The status of the webhook.
     */
    public function update(
        string $webhookId,
        ?string $endpoint = null,
        ?array $events = null,
        ?string $status = null,
    ): Response {
        return $this->connector->send(new UpdateWebhookRequest(
            $webhookId,
            $endpoint,
            $events,
            $status,
        ));
    }

    /**
     * Remove an existing webhook
     *
     * @param  string  $webhookId  The Webhook ID.
     */
    public function remove(string $webhookId): Response
    {
        return $this->connector->send(new RemoveWebhookRequest($webhookId));
    }

    /**
     * Rotate a webhook signing secret
     *
     * @param  string  $webhookId  The Webhook ID.
     */
    public function rotateSigningSecret(string $webhookId): Response
    {
        return $this->connector->send(new RotateWebhookSigningSecretRequest($webhookId));
    }

    /**
     * Retrieve a list of webhook events
     *
     * `$response->dto()` returns a ListResponse<WebhookEvent>.
     *
     * @param  string  $webhookId  The Webhook ID.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     */
    public function listEvents(string $webhookId, ?int $limit = null, ?string $after = null): Response
    {
        return $this->connector->send(new ListWebhookEventsRequest($webhookId, $limit, $after));
    }

    /**
     * Retrieve a single webhook event
     *
     * `$response->dto()` returns a WebhookEvent.
     *
     * @param  string  $webhookId  The Webhook ID.
     * @param  string  $eventId  The Webhook Event ID.
     */
    public function getEvent(string $webhookId, string $eventId): Response
    {
        return $this->connector->send(new GetWebhookEventRequest($webhookId, $eventId));
    }

    /**
     * Replay a webhook event
     *
     * @param  string  $webhookId  The Webhook ID.
     * @param  string  $eventId  The Webhook Event ID.
     */
    public function replayEvent(string $webhookId, string $eventId): Response
    {
        return $this->connector->send(new ReplayWebhookEventRequest($webhookId, $eventId));
    }

    /**
     * Retrieve a list of webhook event attempts
     *
     * @param  string  $webhookId  The Webhook ID.
     * @param  string  $eventId  The Webhook Event ID.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     */
    public function listEventAttempts(
        string $webhookId,
        string $eventId,
        ?int $limit = null,
        ?string $after = null,
    ): Response {
        return $this->connector->send(new ListWebhookEventAttemptsRequest(
            $webhookId,
            $eventId,
            $limit,
            $after,
        ));
    }
}
