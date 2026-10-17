# Resend::segments()

Segments endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Segments`.

## `create()`

`POST /segments` – Create a new segment

```php
Resend::segments()->create(string $name, ?string $audienceId = null, ?array $filter = null): Response
```

- `$name` (`string`, required) The name of the segment.
- `$audienceId` (`string|null`, field `audience_id`) The ID of the audience this segment belongs to.
- `$filter` (`array<string, mixed>|null`) Filter conditions for the segment.

## `list()`

`GET /segments` – Retrieve a list of segments

```php
Resend::segments()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `Segment`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `get()`

`GET /segments/{id}` – Retrieve a single segment

```php
Resend::segments()->get(string $id): Response
```

`$response->dto()` returns a `Segment`.

- `$id` (`string`, required, path `id`) The Segment ID.

## `update()`

`PATCH /segments/{id}` – Update an existing segment

```php
Resend::segments()->update(string $id, string $name): Response
```

- `$id` (`string`, required, path `id`) The Segment ID.
- `$name` (`string`, required) The name of the segment.

## `remove()`

`DELETE /segments/{id}` – Remove an existing segment

```php
Resend::segments()->remove(string $id): Response
```

- `$id` (`string`, required, path `id`) The Segment ID.

## `listContacts()`

`GET /segments/{id}/contacts` – Retrieve a list of contacts in a segment

```php
Resend::segments()->listContacts(
    string $id,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

`$response->dto()` returns a `ListResponse` of `Contact`.

- `$id` (`string`, required, path `id`) The Segment ID.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.
