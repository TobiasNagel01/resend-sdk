# Resend::events()

Events endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Events`.

## `create()`

`POST /events` – Create an event

```php
Resend::events()->create(string $name, array|Omit|null $schema = Omit::Value): Response
```

- `$name` (`string`, required) The name of the event. Cannot start with the reserved `resend:` prefix.
- `$schema` (`array<string, mixed>|null|Omit`) An optional flat key/type map defining the event payload schema. Supported types are `string`, `number`, `boolean`, and `date`.

## `list()`

`GET /events` – Retrieve a list of events

```php
Resend::events()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `Event`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `send()`

`POST /events/send` – Send an event

```php
Resend::events()->send(
    string $event,
    ?string $contactId = null,
    ?string $email = null,
    ?array $payload = null,
): Response
```

- `$event` (`string`, required) The name of the event to send.
- `$contactId` (`string|null`, field `contact_id`) The ID of the contact to associate with this event. Exactly one of `contact_id` or `email` must be provided.
- `$email` (`string|null`) The email address to associate with this event. Exactly one of `contact_id` or `email` must be provided.
- `$payload` (`array<string, mixed>|null`) An optional payload of key/value pairs to include with the event.

## `get()`

`GET /events/{identifier}` – Retrieve a single event

```php
Resend::events()->get(string $identifier): Response
```

`$response->dto()` returns an `Event`.

- `$identifier` (`string`, required, path `identifier`) The event ID (UUID) or event name.

## `update()`

`PATCH /events/{identifier}` – Update an event

```php
Resend::events()->update(string $identifier, ?array $schema): Response
```

- `$identifier` (`string`, required, path `identifier`) The event ID (UUID) or event name.
- `$schema` (`array<string, mixed>|null`, required) A flat key/type map defining the event payload schema. Set to `null` to clear the schema. Supported types are `string`, `number`, `boolean`, and `date`.

## `remove()`

`DELETE /events/{identifier}` – Delete an event

```php
Resend::events()->remove(string $identifier): Response
```

- `$identifier` (`string`, required, path `identifier`) The event ID (UUID) or event name.
