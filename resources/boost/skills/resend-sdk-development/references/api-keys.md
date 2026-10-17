# Resend::apiKeys()

ApiKeys endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\ApiKeys`.

## `create()`

`POST /api-keys` – Create a new API key

```php
Resend::apiKeys()->create(string $name, ?string $permission = null, ?string $domainId = null): Response
```

- `$name` (`string`, required) The API key name.
- `$permission` (`'full_access'|'sending_access'|null`) The API key can have full access to Resend’s API or be only restricted to send emails. * full_access - Can create, delete, get, and update any resource. * sending_access - Can only send emails.
- `$domainId` (`string|null`, field `domain_id`) Restrict an API key to send emails only from a specific domain. Only used when the permission is sending_access.

## `list()`

`GET /api-keys` – Retrieve a list of API keys

```php
Resend::apiKeys()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `ApiKey`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `update()`

`PATCH /api-keys/{api_key_id}` – Update an existing API key

```php
Resend::apiKeys()->update(string $apiKeyId, string $name): Response
```

- `$apiKeyId` (`string`, required, path `api_key_id`) The API key ID.
- `$name` (`string`, required) The API key name.

## `remove()`

`DELETE /api-keys/{api_key_id}` – Remove an existing API key

```php
Resend::apiKeys()->remove(string $apiKeyId): Response
```

- `$apiKeyId` (`string`, required, path `api_key_id`) The API key ID.
