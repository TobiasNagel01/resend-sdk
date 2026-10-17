# Resend::templates()

Templates endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Templates`.

## `create()`

`POST /templates` – Create a template

```php
Resend::templates()->create(
    string $name,
    string $html,
    ?string $alias = null,
    ?string $from = null,
    ?string $subject = null,
    ?array $replyTo = null,
    ?string $text = null,
    ?array $variables = null,
): Response
```

- `$name` (`string`, required) The name of the template.
- `$html` (`string`, required) The HTML version of the template.
- `$alias` (`string|null`) The alias of the template.
- `$from` (`string|null`) Sender email address. To include a friendly name, use the format "Your Name <sender@domain.com>".
- `$subject` (`string|null`) Email subject.
- `$replyTo` (`list<string>|null`, field `reply_to`) Reply-to email addresses.
- `$text` (`string|null`) The plain text version of the template.
- `$variables` (`list<array{key: string, type: 'string'|'number'|'boolean'|'object'|'list', fallback_value?: string|int|float|bool|array<string, mixed>|list<mixed>}>|null`)

## `list()`

`GET /templates` – Retrieve a list of templates

```php
Resend::templates()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `Template`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `get()`

`GET /templates/{id}` – Retrieve a single template

```php
Resend::templates()->get(string $id): Response
```

`$response->dto()` returns a `Template`.

- `$id` (`string`, required, path `id`) The Template ID or alias.

## `update()`

`PATCH /templates/{id}` – Update an existing template

```php
Resend::templates()->update(
    string $id,
    ?string $name = null,
    ?string $alias = null,
    ?string $from = null,
    ?string $subject = null,
    ?array $replyTo = null,
    ?string $html = null,
    ?string $text = null,
    ?array $variables = null,
): Response
```

- `$id` (`string`, required, path `id`) The Template ID or alias.
- `$name` (`string|null`) The name of the template.
- `$alias` (`string|null`) The alias of the template.
- `$from` (`string|null`) Sender email address. To include a friendly name, use the format "Your Name <sender@domain.com>".
- `$subject` (`string|null`) Email subject.
- `$replyTo` (`list<string>|null`, field `reply_to`) Reply-to email addresses.
- `$html` (`string|null`) The HTML version of the template.
- `$text` (`string|null`) The plain text version of the template.
- `$variables` (`list<array{key: string, type: 'string'|'number'|'boolean'|'object'|'list', fallback_value?: string|int|float|bool|array<string, mixed>|list<mixed>}>|null`)

## `remove()`

`DELETE /templates/{id}` – Remove an existing template

```php
Resend::templates()->remove(string $id): Response
```

- `$id` (`string`, required, path `id`) The Template ID or alias.

## `publish()`

`POST /templates/{id}/publish` – Publish a template

```php
Resend::templates()->publish(string $id): Response
```

- `$id` (`string`, required, path `id`) The Template ID or alias.

## `duplicate()`

`POST /templates/{id}/duplicate` – Duplicate a template

```php
Resend::templates()->duplicate(string $id): Response
```

- `$id` (`string`, required, path `id`) The Template ID or alias.
