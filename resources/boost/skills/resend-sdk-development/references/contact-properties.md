# Resend::contactProperties()

ContactProperties endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\ContactProperties`.

## `create()`

`POST /contact-properties` – Create a new contact property

```php
Resend::contactProperties()->create(string $key, string $type, string|int|float|null $fallbackValue = null): Response
```

- `$key` (`string`, required) The property key. Max length is 50 characters. Only alphanumeric characters and underscores are allowed.
- `$type` (`'string'|'number'`, required) The property type.
- `$fallbackValue` (`string|int|float|null`, field `fallback_value`) The default value to use when the property is not set for a contact. Must match the type specified in the type field.

## `list()`

`GET /contact-properties` – Retrieve a list of contact properties

```php
Resend::contactProperties()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `ContactProperty`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `get()`

`GET /contact-properties/{id}` – Retrieve a single contact property

```php
Resend::contactProperties()->get(string $id): Response
```

`$response->dto()` returns a `ContactProperty`.

- `$id` (`string`, required, path `id`) The Contact Property ID.

## `update()`

`PATCH /contact-properties/{id}` – Update an existing contact property

```php
Resend::contactProperties()->update(string $id, string|int|float|null $fallbackValue = null): Response
```

- `$id` (`string`, required, path `id`) The Contact Property ID.
- `$fallbackValue` (`string|int|float|null`, field `fallback_value`) The default value to use when the property is not set for a contact. Must match the type of the property.

## `remove()`

`DELETE /contact-properties/{id}` – Remove an existing contact property

```php
Resend::contactProperties()->remove(string $id): Response
```

- `$id` (`string`, required, path `id`) The Contact Property ID.
