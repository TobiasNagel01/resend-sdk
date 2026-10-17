# Resend::emails()

Emails endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Emails`.

## `send()`

`POST /emails` – Send an email

```php
Resend::emails()->send(
    string $from,
    string|array $to,
    string $subject,
    string|array|null $bcc = null,
    string|array|null $cc = null,
    string|array|null $replyTo = null,
    ?string $html = null,
    ?string $text = null,
    ?array $template = null,
    ?array $customHeaders = null,
    ?string $scheduledAt = null,
    ?array $attachments = null,
    ?array $tags = null,
    ?string $topicId = null,
    ?string $idempotencyKey = null,
): Response
```

- `$from` (`string`, required) Sender email address. To include a friendly name, use the format "Your Name <sender@domain.com>".
- `$to` (`string|list<string>`, required) Recipient email address. For multiple addresses, send as an array of strings. Max 50.
- `$subject` (`string`, required) Email subject.
- `$bcc` (`string|list<string>|null`) Bcc recipient email address. For multiple addresses, send as an array of strings.
- `$cc` (`string|list<string>|null`) Cc recipient email address. For multiple addresses, send as an array of strings.
- `$replyTo` (`string|list<string>|null`, field `reply_to`) Reply-to email address. For multiple addresses, send as an array of strings.
- `$html` (`string|null`) The HTML version of the message.
- `$text` (`string|null`) The plain text version of the message.
- `$template` (`array{id: string, variables?: array<string, mixed>}|null`) Use a published template to send the email. If provided, do not include html or text.
- `$customHeaders` (`array<string, mixed>|null`, field `headers`) Custom headers to add to the email.
- `$scheduledAt` (`string|null`, field `scheduled_at`) Schedule email to be sent later. The date should be in ISO 8601 format.
- `$attachments` (`list<array{content?: string, filename?: string, path?: string, content_type?: string, content_id?: string}>|null`)
- `$tags` (`list<array{name?: string, value?: string}>|null`)
- `$topicId` (`string|null`, field `topic_id`) The topic ID to scope the email to. If the recipient is a contact and opted-in to the topic, the email is sent. If opted-out, the email is not sent. If the recipient is not a contact, the email is sent if the topic's default subscription is opt_in.
- `$idempotencyKey` (`string|null`, header `Idempotency-Key`) A unique identifier for the request to ensure emails are only sent once. [Learn more](https://resend.com/docs/dashboard/emails/idempotency-keys)

## `list()`

`GET /emails` – Retrieve a list of emails

```php
Resend::emails()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `Email`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `get()`

`GET /emails/{email_id}` – Retrieve a single email

```php
Resend::emails()->get(string $emailId): Response
```

`$response->dto()` returns an `Email`.

- `$emailId` (`string`, required, path `email_id`) The ID of the email.

## `update()`

`PATCH /emails/{email_id}` – Update a single email

```php
Resend::emails()->update(string $emailId, string $scheduledAt): Response
```

- `$emailId` (`string`, required, path `email_id`) The ID of the email.
- `$scheduledAt` (`string`, required, field `scheduled_at`) Schedule email to be sent later. The date should be in ISO 8601 format (e.g: 2024-08-05T11:52:01.858Z) or natural language (e.g.: "in 1 min").

## `cancel()`

`POST /emails/{email_id}/cancel` – Cancel the schedule of the e-mail.

```php
Resend::emails()->cancel(string $emailId): Response
```

`$response->dto()` returns an `Email`.

- `$emailId` (`string`, required, path `email_id`) The ID of the email.

## `share()`

`POST /emails/{email_id}/share` – Create a shareable link for a sent or received email.

```php
Resend::emails()->share(string $emailId, ?string $expiresIn = null): Response
```

- `$emailId` (`string`, required, path `email_id`) The ID of the email.
- `$expiresIn` (`string|null`, field `expires_in`) How long the link stays valid for, as a duration like `10m`, `2 hours`, or `1 day`. Defaults to `48h` and cannot exceed 48 hours.

## `sendBatch()`

`POST /emails/batch` – Trigger up to 100 batch emails at once.

```php
Resend::emails()->sendBatch(array $emails, ?string $idempotencyKey = null): Response
```

- `$emails` (`list<array{from: string, to: string|list<string>, subject: string, bcc?: string|list<string>, cc?: string|list<string>, reply_to?: string|list<string>, html?: string, text?: string, template?: array{id: string, variables?: array<string, mixed>}, headers?: array<string, mixed>, scheduled_at?: string, attachments?: list<array{content?: string, filename?: string, path?: string, content_type?: string, content_id?: string}>, tags?: list<array{name?: string, value?: string}>, topic_id?: string}>`, required) The items to send.
- `$idempotencyKey` (`string|null`, header `Idempotency-Key`) A unique identifier for the request to ensure emails are only sent once. [Learn more](https://resend.com/docs/dashboard/emails/idempotency-keys)

## `listAttachments()`

`GET /emails/{email_id}/attachments` – Retrieve a list of attachments for a sent email

```php
Resend::emails()->listAttachments(
    string $emailId,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

`$response->dto()` returns a `ListResponse` of `Attachment`.

- `$emailId` (`string`, required, path `email_id`) The ID of the email.
- `$limit` (`int|null`, query `limit`) Maximum number of attachments to return.
- `$after` (`string|null`, query `after`) Pagination cursor to fetch results after this attachment ID. Cannot be used with 'before'.
- `$before` (`string|null`, query `before`) Pagination cursor to fetch results before this attachment ID. Cannot be used with 'after'.

## `getAttachment()`

`GET /emails/{email_id}/attachments/{attachment_id}` – Retrieve a single attachment for a sent email

```php
Resend::emails()->getAttachment(string $emailId, string $attachmentId): Response
```

`$response->dto()` returns an `Attachment`.

- `$emailId` (`string`, required, path `email_id`) The ID of the email.
- `$attachmentId` (`string`, required, path `attachment_id`) The ID of the attachment.

## `listReceiving()`

`GET /emails/receiving` – Retrieve a list of received emails

```php
Resend::emails()->listReceiving(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `ReceivedEmail`.

- `$limit` (`int|null`, query `limit`) Maximum number of received emails to return.
- `$after` (`string|null`, query `after`) Pagination cursor to fetch results after this email ID. Cannot be used with 'before'.
- `$before` (`string|null`, query `before`) Pagination cursor to fetch results before this email ID. Cannot be used with 'after'.

## `getReceiving()`

`GET /emails/receiving/{email_id}` – Retrieve a single received email

```php
Resend::emails()->getReceiving(string $emailId): Response
```

`$response->dto()` returns a `ReceivedEmail`.

- `$emailId` (`string`, required, path `email_id`) The ID of the received email.

## `listReceivingAttachments()`

`GET /emails/receiving/{email_id}/attachments` – Retrieve a list of attachments for a received email

```php
Resend::emails()->listReceivingAttachments(
    string $emailId,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

`$response->dto()` returns a `ListResponse` of `Attachment`.

- `$emailId` (`string`, required, path `email_id`) The ID of the received email.
- `$limit` (`int|null`, query `limit`) Maximum number of attachments to return.
- `$after` (`string|null`, query `after`) Pagination cursor to fetch results after this attachment ID. Cannot be used with 'before'.
- `$before` (`string|null`, query `before`) Pagination cursor to fetch results before this attachment ID. Cannot be used with 'after'.

## `getReceivingAttachment()`

`GET /emails/receiving/{email_id}/attachments/{attachment_id}` – Retrieve a single attachment for a received email

```php
Resend::emails()->getReceivingAttachment(string $emailId, string $attachmentId): Response
```

`$response->dto()` returns an `Attachment`.

- `$emailId` (`string`, required, path `email_id`) The ID of the received email.
- `$attachmentId` (`string`, required, path `attachment_id`) The ID of the attachment.

## `metrics()`

`GET /emails/metrics` – Retrieve account-level email metrics

```php
Resend::emails()->metrics(
    ?string $startDate = null,
    ?string $endDate = null,
    ?string $timezone = null,
    ?string $granularity = null,
    ?array $metrics = null,
    ?array $dimensions = null,
    ?array $domainId = null,
    ?array $emailId = null,
    ?array $broadcastId = null,
): Response
```

- `$startDate` (`string|null`, query `start_date`) The start of the date range, as an ISO 8601 date or datetime. Must be on or before `end_date`. Defaults to 6 days before `end_date`.
- `$endDate` (`string|null`, query `end_date`) The end of the date range, as an ISO 8601 date or datetime. Values in the future are clamped to the current time. Defaults to now.
- `$timezone` (`string|null`, query `timezone`) The IANA timezone (e.g. `America/New_York`) used to bucket periods when `period` is in `dimensions`.
- `$granularity` (`'hourly'|'daily'|'weekly'|'monthly'|null`, query `granularity`) The bucket size used when `period` is in `dimensions`. The date range can't produce more than 10,000 periods at the chosen granularity.
- `$metrics` (`list<'received'|'delivered'|'complained'|'suppressed'|'bounced'|'bounced_transient'|'bounced_permanent'|'bounced_undetermined'|'opened'|'clicked'|'unsubscribed'|'delivery_delayed'|'failed'|'sent'|'unique_opened'|'unique_clicked'|'delivery_rate'|'open_rate'|'click_rate'|'bounce_rate'|'complaint_rate'|'unsubscribe_rate'>|null`, query `metrics`) List of metrics to include in the response. Defaults to all metrics. Accepts a comma-separated value, the parameter repeated, or a mix of both.
- `$dimensions` (`list<'period'|'domain'|'email'|'broadcast'>|null`, query `dimensions`) List of dimensions to break the response down by. `email` cannot be combined with `broadcast`. Defaults to `[]`, returning a single `totals` row for the whole range, with no `data`. Accepts a comma-separated value, the parameter repeated, or a mix of both.
- `$domainId` (`list<string>|null`, query `domain_id`) List of sending domain IDs to restrict the response to, up to 100. Accepts a comma-separated value, the parameter repeated, or a mix of both.
- `$emailId` (`list<string>|null`, query `email_id`) List of email IDs to restrict the response to, up to 100. Cannot be combined with the `broadcast` dimension or `broadcast_id`. Accepts a comma-separated value, the parameter repeated, or a mix of both.
- `$broadcastId` (`list<string>|null`, query `broadcast_id`) List of broadcast IDs to restrict the response to, up to 100. Cannot be combined with the `email` dimension or `email_id`. Accepts a comma-separated value, the parameter repeated, or a mix of both.
