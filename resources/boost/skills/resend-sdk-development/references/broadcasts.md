# Resend::broadcasts()

Broadcasts endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Broadcasts`.

## `create()`

`POST /broadcasts` – Create a broadcast

```php
Resend::broadcasts()->create(
    string $segmentId,
    string $from,
    string $subject,
    ?string $name = null,
    ?string $audienceId = null,
    ?array $replyTo = null,
    ?string $previewText = null,
    ?string $html = null,
    ?string $text = null,
    ?string $topicId = null,
    ?bool $send = null,
    ?string $scheduledAt = null,
): Response
```

- `$segmentId` (`string`, required, field `segment_id`) Unique identifier of the segment this broadcast will be sent to.
- `$from` (`string`, required) The email address of the sender.
- `$subject` (`string`, required) The subject line of the email.
- `$name` (`string|null`) Name of the broadcast.
- `$audienceId` (`string|null`, field `audience_id`) Use `segment_id` instead. Unique identifier of the segment this broadcast will be sent to.
- `$replyTo` (`list<string>|null`, field `reply_to`) The email addresses to which replies should be sent.
- `$previewText` (`string|null`, field `preview_text`) The preview text of the email.
- `$html` (`string|null`) The HTML version of the message.
- `$text` (`string|null`) The plain text version of the message.
- `$topicId` (`string|null`, field `topic_id`) The topic ID that the broadcast will be scoped to.
- `$send` (`bool|null`) Whether to send the broadcast immediately or keep it as a draft.
- `$scheduledAt` (`string|null`, field `scheduled_at`) Schedule time to send the broadcast. Can only be used if `send` is true.

## `list()`

`GET /broadcasts` – Retrieve a list of broadcasts

```php
Resend::broadcasts()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `Broadcast`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `remove()`

`DELETE /broadcasts/{id}` – Remove an existing broadcast that is in the draft status

```php
Resend::broadcasts()->remove(string $id): Response
```

- `$id` (`string`, required, path `id`) The Broadcast ID.

## `get()`

`GET /broadcasts/{id}` – Retrieve a single broadcast

```php
Resend::broadcasts()->get(string $id): Response
```

`$response->dto()` returns a `Broadcast`.

- `$id` (`string`, required, path `id`) The Broadcast ID.

## `update()`

`PATCH /broadcasts/{id}` – Update an existing broadcast

```php
Resend::broadcasts()->update(
    string $id,
    ?string $name = null,
    ?string $audienceId = null,
    ?string $segmentId = null,
    ?string $from = null,
    ?string $subject = null,
    ?array $replyTo = null,
    ?string $previewText = null,
    ?string $html = null,
    ?string $text = null,
    ?string $topicId = null,
): Response
```

- `$id` (`string`, required, path `id`) The Broadcast ID.
- `$name` (`string|null`) Name of the broadcast.
- `$audienceId` (`string|null`, field `audience_id`) Use `segment_id` instead. Unique identifier of the audience this broadcast will be sent to.
- `$segmentId` (`string|null`, field `segment_id`) Unique identifier of the segment this broadcast will be sent to.
- `$from` (`string|null`) The email address of the sender.
- `$subject` (`string|null`) The subject line of the email.
- `$replyTo` (`list<string>|null`, field `reply_to`) The email addresses to which replies should be sent.
- `$previewText` (`string|null`, field `preview_text`) The preview text of the email.
- `$html` (`string|null`) The HTML version of the message.
- `$text` (`string|null`) The plain text version of the message.
- `$topicId` (`string|null`, field `topic_id`) The topic ID that the broadcast will be scoped to.

## `send()`

`POST /broadcasts/{id}/send` – Send or schedule a broadcast

```php
Resend::broadcasts()->send(string $id, ?string $scheduledAt = null): Response
```

- `$id` (`string`, required, path `id`) The Broadcast ID.
- `$scheduledAt` (`string|null`, field `scheduled_at`) Schedule email to be sent later. The date should be in ISO 8601 format.

## `cancel()`

`POST /broadcasts/{id}/cancel` – Cancel a broadcast

Cancels a broadcast that is queued or scheduled. Canceling a queued broadcast stops it mid-send; emails already sent are not affected, but no further emails will go out.

```php
Resend::broadcasts()->cancel(string $id): Response
```

- `$id` (`string`, required, path `id`) The Broadcast ID.

## `duplicate()`

`POST /broadcasts/{id}/duplicate` – Duplicate a broadcast

Creates a new draft broadcast with the same segment, topic, sender, subject, reply-to, preview text, and content as the source. The copy is named after the source with " (copy)" appended, truncated to 70 characters.

```php
Resend::broadcasts()->duplicate(string $id): Response
```

- `$id` (`string`, required, path `id`) The Broadcast ID.

## `listRecipients()`

`GET /broadcasts/{id}/recipients` – Retrieve broadcast recipients

Retrieve the recipients of a broadcast for a given event type, such as who opened, clicked, or bounced.

```php
Resend::broadcasts()->listRecipients(
    string $id,
    string $type,
    ?string $email = null,
    ?string $bounceType = null,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

- `$id` (`string`, required, path `id`) The Broadcast ID.
- `$type` (`'sent'|'delivered'|'opened'|'clicked'|'bounced'|'complained'|'unsubscribed'|'suppressed'`, required, query `type`) The recipient event type to filter by.
- `$email` (`string|null`, query `email`) Filter recipients whose email address contains this value.
- `$bounceType` (`'permanent'|'transient'|'undetermined'|null`, query `bounce_type`) Filter bounced recipients by bounce type. Only valid when `type` is `bounced`.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `listClickedLinks()`

`GET /broadcasts/{id}/clicked-links` – Retrieve a broadcast's clicked links

```php
Resend::broadcasts()->listClickedLinks(
    string $id,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

- `$id` (`string`, required, path `id`) The Broadcast ID.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.
