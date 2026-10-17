# Resend::logs()

Logs endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Logs`.

## `list()`

`GET /logs` – Retrieve a list of logs

```php
Resend::logs()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `Log`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `get()`

`GET /logs/{log_id}` – Retrieve a single log

```php
Resend::logs()->get(string $logId): Response
```

`$response->dto()` returns a `Log`.

- `$logId` (`string`, required, path `log_id`) The ID of the log.
