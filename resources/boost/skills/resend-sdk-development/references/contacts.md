# Resend::contacts()

Contacts endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Contacts`.

## `create()`

`POST /contacts` – Create a new contact

```php
Resend::contacts()->create(
    string $email,
    ?string $firstName = null,
    ?string $lastName = null,
    ?bool $unsubscribed = null,
    ?array $properties = null,
    ?array $segments = null,
    ?array $topics = null,
    ?string $audienceId = null,
): Response
```

- `$email` (`string`, required) Email address of the contact.
- `$firstName` (`string|null`, field `first_name`) First name of the contact.
- `$lastName` (`string|null`, field `last_name`) Last name of the contact.
- `$unsubscribed` (`bool|null`) The Contact's global subscription status. If set to true, the contact will be unsubscribed from all Broadcasts.
- `$properties` (`array<string, mixed>|null`) A map of custom property keys and values to create.
- `$segments` (`list<array{id?: string}>|null`) Array of segment IDs to add the contact to.
- `$topics` (`list<array{id?: string, subscription?: 'opt_in'|'opt_out'}>|null`) Array of topic subscriptions for the contact.
- `$audienceId` (`string|null`, field `audience_id`) Unique identifier of the audience to which the contact belongs.

## `list()`

`GET /contacts` – Retrieve a list of contacts

```php
Resend::contacts()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `Contact`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `createImport()`

`POST /contacts/imports` – Create a contact import

```php
Resend::contacts()->createImport(
    mixed $file,
    array|string|null $columnMap = null,
    ?string $onConflict = null,
    array|string|null $segments = null,
    array|string|null $topics = null,
    string $fileName = 'contacts.csv',
): Response
```

- `$file` (`resource|\Psr\Http\Message\StreamInterface|string`, required) CSV file to import. Maximum size is 50MB.
- `$columnMap` (`array<mixed>|string|null`, field `column_map`) JSON-encoded object mapping contact fields and custom property keys to CSV column names. Supports `email`, `first_name`, `last_name`, `unsubscribed`, and `properties`. Custom property mappings can include `type` as `string`, `number`, or `boolean`; defaults to `string`.
- `$onConflict` (`'upsert'|'skip'|null`, field `on_conflict`) Strategy to use when an imported contact already exists.
- `$segments` (`array<mixed>|string|null`) JSON-encoded array of segments to add imported contacts to.
- `$topics` (`array<mixed>|string|null`) JSON-encoded array of topic subscriptions to apply to imported contacts. Each `subscription` must be `opt_in` or `opt_out`.
- `$fileName` (`string`, filename `file`) Filename sent with the `file` upload.

## `listImports()`

`GET /contacts/imports` – Retrieve a list of contact imports

```php
Resend::contacts()->listImports(
    ?string $status = null,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

`$response->dto()` returns a `ListResponse` of `ContactImport`.

- `$status` (`'queued'|'in_progress'|'completed'|'failed'|null`, query `status`) Filter contact imports by status.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `getImport()`

`GET /contacts/imports/{id}` – Retrieve a single contact import

```php
Resend::contacts()->getImport(string $id): Response
```

`$response->dto()` returns a `ContactImport`.

- `$id` (`string`, required, path `id`) The Contact Import ID.

## `get()`

`GET /contacts/{id}` – Retrieve a single contact by ID or email

```php
Resend::contacts()->get(string $id): Response
```

`$response->dto()` returns a `Contact`.

- `$id` (`string`, required, path `id`) The Contact ID or email address.

## `update()`

`PATCH /contacts/{id}` – Update a single contact by ID or email

```php
Resend::contacts()->update(
    string $id,
    ?string $email = null,
    ?string $firstName = null,
    ?string $lastName = null,
    ?bool $unsubscribed = null,
    ?array $properties = null,
): Response
```

- `$id` (`string`, required, path `id`) The Contact ID or email address.
- `$email` (`string|null`) Email address of the contact.
- `$firstName` (`string|null`, field `first_name`) First name of the contact.
- `$lastName` (`string|null`, field `last_name`) Last name of the contact.
- `$unsubscribed` (`bool|null`) The Contact's global subscription status. If set to true, the contact will be unsubscribed from all Broadcasts.
- `$properties` (`array<string, mixed>|null`) A map of custom property keys and values to update.

## `remove()`

`DELETE /contacts/{id}` – Remove an existing contact by ID or email

```php
Resend::contacts()->remove(string $id): Response
```

- `$id` (`string`, required, path `id`) The Contact ID or email address.

## `listSegments()`

`GET /contacts/{contact_id}/segments` – Retrieve a list of segments for a contact

```php
Resend::contacts()->listSegments(
    string $contactId,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

`$response->dto()` returns a `ListResponse` of `Segment`.

- `$contactId` (`string`, required, path `contact_id`) The Contact ID or email address.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `addSegment()`

`POST /contacts/{contact_id}/segments/{segment_id}` – Add a contact to a segment

```php
Resend::contacts()->addSegment(string $contactId, string $segmentId): Response
```

- `$contactId` (`string`, required, path `contact_id`) The Contact ID or email address.
- `$segmentId` (`string`, required, path `segment_id`) The Segment ID.

## `removeSegment()`

`DELETE /contacts/{contact_id}/segments/{segment_id}` – Remove a contact from a segment

```php
Resend::contacts()->removeSegment(string $contactId, string $segmentId): Response
```

- `$contactId` (`string`, required, path `contact_id`) The Contact ID or email address.
- `$segmentId` (`string`, required, path `segment_id`) The Segment ID.

## `listTopics()`

`GET /contacts/{contact_id}/topics` – Retrieve topics for a contact

```php
Resend::contacts()->listTopics(
    string $contactId,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

- `$contactId` (`string`, required, path `contact_id`) The Contact ID or email address.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `updateTopics()`

`PATCH /contacts/{contact_id}/topics` – Update topics for a contact

```php
Resend::contacts()->updateTopics(string $contactId, array $topics): Response
```

- `$contactId` (`string`, required, path `contact_id`) The Contact ID or email address.
- `$topics` (`list<array{id?: string, subscription?: 'opt_in'|'opt_out'}>`, required)
