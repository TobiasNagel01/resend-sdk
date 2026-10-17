# Resend::suppressions()

Suppressions endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Suppressions`.

## `add()`

`POST /suppressions` – Create a suppression

```php
Resend::suppressions()->add(string $email): Response
```

- `$email` (`string`, required) Email address to suppress.

## `list()`

`GET /suppressions` – Retrieve a list of suppressions

```php
Resend::suppressions()->list(
    ?string $origin = null,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

`$response->dto()` returns a `ListResponse` of `Suppression`.

- `$origin` (`'bounce'|'complaint'|'manual'|null`, query `origin`) Filter suppressions by origin.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `batchAdd()`

`POST /suppressions/batch/add` – Add up to 100 suppressions at once

```php
Resend::suppressions()->batchAdd(array $emails): Response
```

- `$emails` (`list<string>`, required) Email addresses to suppress.

## `batchRemove()`

`POST /suppressions/batch/remove` – Remove up to 100 suppressions at once

```php
Resend::suppressions()->batchRemove(?array $emails = null, ?array $ids = null): Response
```

- `$emails` (`list<string>|null`) Email addresses to remove from the suppression list.
- `$ids` (`list<string>|null`) Suppression IDs to remove from the suppression list.

## `get()`

`GET /suppressions/{suppression}` – Retrieve a single suppression by ID or email

```php
Resend::suppressions()->get(string $suppression): Response
```

`$response->dto()` returns a `Suppression`.

- `$suppression` (`string`, required, path `suppression`) The Suppression ID or email address.

## `remove()`

`DELETE /suppressions/{suppression}` – Remove a single suppression by ID or email

```php
Resend::suppressions()->remove(string $suppression): Response
```

- `$suppression` (`string`, required, path `suppression`) The Suppression ID or email address.
