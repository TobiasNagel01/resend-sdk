# Resend::topics()

Topics endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Topics`.

## `create()`

`POST /topics` – Create a new topic

```php
Resend::topics()->create(
    string $name,
    string $defaultSubscription,
    ?string $description = null,
    ?string $visibility = null,
): Response
```

- `$name` (`string`, required) The name of the topic. Max 50 characters.
- `$defaultSubscription` (`'opt_in'|'opt_out'`, required, field `default_subscription`) The default subscription status for the topic. Cannot be changed after creation.
- `$description` (`string|null`) A description of the topic. Max 200 characters.
- `$visibility` (`'public'|'private'|null`) The visibility of the topic. Public topics are visible to all contacts on the unsubscribe page. Private topics are only visible to opted-in contacts.

## `list()`

`GET /topics` – Retrieve a list of topics

```php
Resend::topics()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `Topic`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `get()`

`GET /topics/{id}` – Retrieve a single topic

```php
Resend::topics()->get(string $id): Response
```

`$response->dto()` returns a `Topic`.

- `$id` (`string`, required, path `id`) The Topic ID.

## `update()`

`PATCH /topics/{id}` – Update an existing topic

```php
Resend::topics()->update(
    string $id,
    ?string $name = null,
    ?string $description = null,
    ?string $visibility = null,
): Response
```

- `$id` (`string`, required, path `id`) The Topic ID.
- `$name` (`string|null`) The name of the topic. Max 50 characters.
- `$description` (`string|null`) A description of the topic. Max 200 characters.
- `$visibility` (`'public'|'private'|null`) The visibility of the topic.

## `remove()`

`DELETE /topics/{id}` – Remove an existing topic

```php
Resend::topics()->remove(string $id): Response
```

- `$id` (`string`, required, path `id`) The Topic ID.
