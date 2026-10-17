# Resend::webhooks()

Webhooks endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Webhooks`.

## `create()`

`POST /webhooks` – Create a new webhook

```php
Resend::webhooks()->create(string $endpoint, array $events): Response
```

- `$endpoint` (`string`, required) The URL where webhook events will be sent.
- `$events` (`list<string>`, required) Array of event types to subscribe to.

## `list()`

`GET /webhooks` – Retrieve a list of webhooks

```php
Resend::webhooks()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `Webhook`.

- `$limit` (`int|null`, query `limit`) Maximum number of webhooks to return.
- `$after` (`string|null`, query `after`) Pagination cursor to fetch results after this webhook ID. Cannot be used with 'before'.
- `$before` (`string|null`, query `before`) Pagination cursor to fetch results before this webhook ID. Cannot be used with 'after'.

## `get()`

`GET /webhooks/{webhook_id}` – Retrieve a single webhook

```php
Resend::webhooks()->get(string $webhookId): Response
```

`$response->dto()` returns a `Webhook`.

- `$webhookId` (`string`, required, path `webhook_id`) The Webhook ID.

## `update()`

`PATCH /webhooks/{webhook_id}` – Update an existing webhook

```php
Resend::webhooks()->update(
    string $webhookId,
    ?string $endpoint = null,
    ?array $events = null,
    ?string $status = null,
): Response
```

- `$webhookId` (`string`, required, path `webhook_id`) The Webhook ID.
- `$endpoint` (`string|null`) The URL where webhook events will be sent.
- `$events` (`list<string>|null`) Array of event types to subscribe to.
- `$status` (`'enabled'|'disabled'|null`) The status of the webhook.

## `remove()`

`DELETE /webhooks/{webhook_id}` – Remove an existing webhook

```php
Resend::webhooks()->remove(string $webhookId): Response
```

- `$webhookId` (`string`, required, path `webhook_id`) The Webhook ID.

## `rotateSigningSecret()`

`POST /webhooks/{webhook_id}/signing-secret/rotate` – Rotate a webhook signing secret

Generates a new signing secret for the webhook and returns it. Payloads delivered after the rotation are signed with the new secret. The previous secret keeps verifying payloads for 24 hours, so both secrets are accepted during that window. A webhook that does not exist or was removed returns a 404 not_found.

```php
Resend::webhooks()->rotateSigningSecret(string $webhookId): Response
```

- `$webhookId` (`string`, required, path `webhook_id`) The Webhook ID.

## `listEvents()`

`GET /webhooks/{webhook_id}/events` – Retrieve a list of webhook events

```php
Resend::webhooks()->listEvents(string $webhookId, ?int $limit = null, ?string $after = null): Response
```

`$response->dto()` returns a `ListResponse` of `WebhookEvent`.

- `$webhookId` (`string`, required, path `webhook_id`) The Webhook ID.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.

## `getEvent()`

`GET /webhooks/{webhook_id}/events/{event_id}` – Retrieve a single webhook event

```php
Resend::webhooks()->getEvent(string $webhookId, string $eventId): Response
```

`$response->dto()` returns a `WebhookEvent`.

- `$webhookId` (`string`, required, path `webhook_id`) The Webhook ID.
- `$eventId` (`string`, required, path `event_id`) The Webhook Event ID.

## `replayEvent()`

`POST /webhooks/{webhook_id}/events/{event_id}/replay` – Replay a webhook event

Queues one more delivery of the event to the webhook. The event must be retrievable through the get event endpoint and the webhook must be enabled; a disabled webhook returns a 422 validation_error. A manual replay does not schedule automatic retries.

```php
Resend::webhooks()->replayEvent(string $webhookId, string $eventId): Response
```

- `$webhookId` (`string`, required, path `webhook_id`) The Webhook ID.
- `$eventId` (`string`, required, path `event_id`) The Webhook Event ID.

## `listEventAttempts()`

`GET /webhooks/{webhook_id}/events/{event_id}/attempts` – Retrieve a list of webhook event attempts

```php
Resend::webhooks()->listEventAttempts(
    string $webhookId,
    string $eventId,
    ?int $limit = null,
    ?string $after = null,
): Response
```

- `$webhookId` (`string`, required, path `webhook_id`) The Webhook ID.
- `$eventId` (`string`, required, path `event_id`) The Webhook Event ID.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
