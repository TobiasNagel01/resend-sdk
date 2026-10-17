# Resend::audiences()

Audiences endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Audiences`.

## `create()`

`POST /audiences` – Create a list of contacts

**Deprecated.**

Deprecated: Use Segments instead. These endpoints still work, but will be removed in the future.

```php
Resend::audiences()->create(string $name): Response
```

- `$name` (`string`, required) The name of the audience you want to create.

## `list()`

`GET /audiences` – Retrieve a list of audiences

**Deprecated.**

Deprecated: Use Segments instead. These endpoints still work, but will be removed in the future.

```php
Resend::audiences()->list(): Response
```

`$response->dto()` returns a `ListResponse` of `Audience`.

## `remove()`

`DELETE /audiences/{id}` – Remove an existing audience

**Deprecated.**

Deprecated: Use Segments instead. These endpoints still work, but will be removed in the future.

```php
Resend::audiences()->remove(string $id): Response
```

- `$id` (`string`, required, path `id`) The Audience ID.

## `get()`

`GET /audiences/{id}` – Retrieve a single audience

**Deprecated.**

Deprecated: Use Segments instead. These endpoints still work, but will be removed in the future.

```php
Resend::audiences()->get(string $id): Response
```

`$response->dto()` returns an `Audience`.

- `$id` (`string`, required, path `id`) The Audience ID.
