# Resend::inboxes()

Inboxes endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Inboxes`.

## `create()`

`POST /inboxes` – Create an inbox

Creates an inbox that sends and receives email at an address on one of your domains. The domain must belong to the team. Without `forwarding`, the domain must have receiving enabled, with DKIM and SPF verified and the inbound MX record verified or pending. With `forwarding` set to `true`, the domain only needs DKIM and SPF verified for sending, and Resend generates a `receiving_address` on the team inbound domain, and a team without an inbound domain gets a 422. A domain that does not meet these rules returns a 422 validation_error. An address or receiving address that is already in use returns a 409. A team that has reached the inbox limit of its plan returns a 403 validation_error. A blocked account returns a 451.

```php
Resend::inboxes()->create(
    string $emailAddress,
    ?string $name = null,
    ?string $fromName = null,
    ?bool $forwarding = null,
): Response
```

- `$emailAddress` (`string`, required, field `email_address`) The inbox email address on one of your domains. The API trims and lowercases it. The part before the `@` is at most 64 characters and contains only letters, numbers, and `. _ % -`. A `+` returns a 422. It cannot start or end with a dot or contain two dots in a row.
- `$name` (`string|null`) Internal name for the inbox. Recipients do not see it. Max 64 characters. Defaults to `email_address`.
- `$fromName` (`string|null`, field `from_name`) The name recipients see when mail is sent from this inbox. A plain name, not a `Name <email>` address. Max 78 characters. It cannot contain a colon, `<`, `>`, line breaks, or other control characters. An email address inside the name must be on a domain the team has verified for sending. An empty string leaves it unset.
- `$forwarding` (`bool|null`) When `true`, Resend provisions a receiving address so you can receive mail without adding an MX record. The address is returned in `receiving_address`.

## `list()`

`GET /inboxes` – Retrieve a list of inboxes

Returns the inboxes of the team, newest first. The list items carry fewer fields than a single inbox. Retrieve an inbox to get all its fields. The `after` and `before` cursors take an inbox ID, and only one of them can be passed, or the request returns a 422. A value that is not a UUID returns a 422, and an unknown ID returns a 404.

```php
Resend::inboxes()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `Inbox`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `get()`

`GET /inboxes/{inbox_id}` – Retrieve a single inbox by ID or email address

```php
Resend::inboxes()->get(string $inboxId): Response
```

`$response->dto()` returns an `Inbox`.

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.

## `update()`

`PATCH /inboxes/{inbox_id}` – Update an existing inbox by ID or email address

Updates the internal name of the inbox or the name recipients see when mail is sent from it. At least one of `name` or `from_name` is required.

```php
Resend::inboxes()->update(string $inboxId, ?string $name = null, ?string $fromName = null): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$name` (`string|null`) New internal name for the inbox. Recipients do not see it. Between 1 and 64 characters after trimming.
- `$fromName` (`string|null`, field `from_name`) The name recipients see when mail is sent from this inbox. A plain name, not a `Name <email>` address. Max 78 characters. It cannot contain a colon, `<`, `>`, line breaks, or other control characters. An email address inside the name must be on a domain the team has verified for sending. An empty string removes it.

## `remove()`

`DELETE /inboxes/{inbox_id}` – Remove an existing inbox by ID or email address

Removes the inbox. An inbox that does not exist or was already removed returns a 404 not_found.

```php
Resend::inboxes()->remove(string $inboxId): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.

## `getAgent()`

`GET /inboxes/{inbox_id}/agent` – Retrieve the agent settings for an inbox

Returns the agent settings of the inbox. An inbox without a configured agent returns empty settings: `instructions` and `tone` are null and `actions` is an empty array.

```php
Resend::inboxes()->getAgent(string $inboxId): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.

## `updateAgent()`

`PATCH /inboxes/{inbox_id}/agent` – Update the agent settings for an inbox

Updates the agent settings of the inbox. The agent is created when the inbox has none. Omitted fields keep their current value.

```php
Resend::inboxes()->updateAgent(
    string $inboxId,
    string|Omit|null $instructions = Omit::Value,
    string|Omit|null $tone = Omit::Value,
    ?array $actions = null,
): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$instructions` (`string|null|Omit`) Instructions the agent follows when it handles the threads of the inbox. Max 4000 characters. Leading and trailing whitespace is trimmed, and the trimmed value must not be empty. Send null to clear the instructions.
- `$tone` (`'concise_professional'|'concise_casual'|'expanded_professional'|'expanded_casual'|null|Omit`) The tone the agent writes in. Send null to clear the tone.
- `$actions` (`list<'draft_reply'|'forward_thread'|'add_labels'|'assign_thread'|'mark_as_spam'|'archive'|'move_to_trash'>|null`) The actions the agent can take. Replaces the whole set. Duplicates are removed. Send an empty array to disable all actions. The old names `archive_thread` and `delete_thread` return a 422. Use `archive` and `move_to_trash`.

## `listLabels()`

`GET /inboxes/{inbox_id}/labels` – Retrieve a list of inbox labels

Returns every label on the inbox, oldest first. The list is not paginated.

```php
Resend::inboxes()->listLabels(string $inboxId): Response
```

`$response->dto()` returns a `ListResponse` of `InboxLabel`.

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.

## `createLabel()`

`POST /inboxes/{inbox_id}/labels` – Create a label on an inbox

A label is a named, colored tag that belongs to one inbox. An inbox can have at most 100 labels. Label names are unique per inbox, compared without case. A duplicate name or a full inbox returns a 422 validation_error.

```php
Resend::inboxes()->createLabel(string $inboxId, string $name, ?string $color = null): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$name` (`string`, required) The name of the label. Max 64 characters. Leading and trailing whitespace is trimmed. Must not match another label on the inbox, compared without case.
- `$color` (`string|null`) The color of the label, as a `#RRGGBB` hex color. It is stored in uppercase. When omitted, a random color from the dashboard palette is used.

## `updateLabel()`

`PATCH /inboxes/{inbox_id}/labels/{label_id}` – Update an existing inbox label

Renames or recolors a label. Omitted fields keep their current value. A new name must not match another label on the inbox, compared without case, or the request returns a 422 validation_error.

```php
Resend::inboxes()->updateLabel(
    string $inboxId,
    string $labelId,
    ?string $name = null,
    ?string $color = null,
): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$labelId` (`string`, required, path `label_id`) The Label ID.
- `$name` (`string|null`) A new name for the label. Max 64 characters. Leading and trailing whitespace is trimmed. Must not match another label on the inbox, compared without case.
- `$color` (`string|null`) A new color for the label, as a `#RRGGBB` hex color. It is stored in uppercase.

## `removeLabel()`

`DELETE /inboxes/{inbox_id}/labels/{label_id}` – Remove an existing inbox label

Deletes the label and removes it from every thread that carries it.

```php
Resend::inboxes()->removeLabel(string $inboxId, string $labelId): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$labelId` (`string`, required, path `label_id`) The Label ID.

## `listThreads()`

`GET /inboxes/{inbox_id}/threads` – Retrieve a list of inbox threads

Returns the threads in an inbox, most recently active first. A thread is a conversation made up of one or more emails. The `after` and `before` cursors take a thread ID, and only one of them can be passed. A cursor that is not a UUID, such as a date, returns a 422 validation_error. A cursor thread that is not in the selected folders returns a 404. To find threads by text, sender, recipient, attachment, or date, use the search threads endpoint.

```php
Resend::inboxes()->listThreads(
    string $inboxId,
    ?array $folders = null,
    ?array $labels = null,
    ?bool $read = null,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

`$response->dto()` returns a `ListResponse` of `InboxThread`.

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$folders` (`list<'inbox'|'archive'|'spam'|'sent'|'trash'>|null`, query `folders`) Comma-separated folders to list, for example `inbox,sent`. Repeating the parameter returns a 422 validation_error. A thread is returned when any of its emails is in one of the folders, so a thread in `inbox` with an email you sent matches both `inbox` and `sent`. Defaults to `inbox`, or to `inbox,archive,sent` when `labels` is set. `spam` and `trash` are only included when you name them.
- `$labels` (`list<string>|null`, query `labels`) Comma-separated label IDs. Returns threads with any of these labels. Up to 50 IDs. An ID that does not exist in the inbox returns a 404. Repeating the parameter returns a 422 validation_error.
- `$read` (`bool|null`, query `read`) `true` returns threads where every email is read. `false` returns threads with at least one unread email. Only the literal values `true` and `false` are accepted.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `searchThreads()`

`GET /inboxes/{inbox_id}/threads/search` – Search the threads of an inbox

Finds threads by the text of their emails, who sent or received them, whether they have attachments, and their dates. Results are ordered by latest activity, newest first, and paginate like the list threads endpoint, so a cursor that is not a thread ID returns a 422. Search can be up to about a minute behind new emails. Different parameters combine, so a thread must match all of them. `folders`, `labels`, and `read` apply to the thread. `query`, `from`, `to`, `cc`, `bcc`, `has_attachment`, `start_date`, and `end_date` must all match the same email in the thread. When any of these email filters is set, the matching email must itself be in one of `folders`. For `sent`, that means an email the inbox sent. When more than 10,000 threads match, search covers the 10,000 with the newest matching email.

```php
Resend::inboxes()->searchThreads(
    string $inboxId,
    ?string $searchQuery = null,
    ?array $from = null,
    ?array $to = null,
    ?array $cc = null,
    ?array $bcc = null,
    ?bool $hasAttachment = null,
    ?string $startDate = null,
    ?string $endDate = null,
    ?array $folders = null,
    ?array $labels = null,
    ?bool $read = null,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$searchQuery` (`string|null`, query `query`) Free text to search for in the subject, body, sender, recipients, and attachment names. Every word must match. Wrap words in double quotes to match an exact phrase. Start a word or quoted phrase with `-` to exclude it. Max 256 characters and 32 words.
- `$from` (`list<string>|null`, query `from`) Comma-separated senders. Each value matches part of the sender's address or name, without case. Returns threads that match any of them. Up to 20 values. Repeating the parameter returns a 422 validation_error.
- `$to` (`list<string>|null`, query `to`) Comma-separated recipients, matched the same way as `from`. Up to 20 values. Repeating the parameter returns a 422 validation_error.
- `$cc` (`list<string>|null`, query `cc`) Comma-separated CC recipients, matched the same way as `from`. Up to 20 values. Repeating the parameter returns a 422 validation_error.
- `$bcc` (`list<string>|null`, query `bcc`) Comma-separated BCC recipients, matched the same way as `from`. Up to 20 values. Repeating the parameter returns a 422 validation_error.
- `$hasAttachment` (`bool|null`, query `has_attachment`) `true` matches emails with an attachment. `false` matches emails without one. Only the literal values `true` and `false` are accepted.
- `$startDate` (`string|null`, query `start_date`) Matches emails sent on or after this date. Accepts a date like `2026-09-01` or an ISO 8601 timestamp, in UTC unless the timestamp has an offset. An empty value returns a 422.
- `$endDate` (`string|null`, query `end_date`) Matches emails sent on or before this date. Same formats as `start_date`. A date covers that whole day, so `start_date=2026-09-01&end_date=2026-09-30` covers all of September. A timestamp is used as given. An `end_date` before `start_date` returns a 422 validation_error. An empty value returns a 422.
- `$folders` (`list<'inbox'|'archive'|'spam'|'sent'|'trash'>|null`, query `folders`) Comma-separated folders to search, for example `inbox,sent`. Repeating the parameter returns a 422 validation_error. A thread is returned when any of its emails is in one of the folders. Defaults to `inbox`, or to `inbox,archive,sent` when `labels` is set. `spam` and `trash` are only included when you name them.
- `$labels` (`list<string>|null`, query `labels`) Comma-separated label IDs. Returns threads with any of these labels. Up to 50 IDs. An ID that does not exist in the inbox returns a 404. Repeating the parameter returns a 422 validation_error.
- `$read` (`bool|null`, query `read`) `true` returns threads where every email is read. `false` returns threads with at least one unread email. Only the literal values `true` and `false` are accepted.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `getThread()`

`GET /inboxes/{inbox_id}/threads/{thread_id}` – Retrieve a single inbox thread

Returns the thread summary. The emails in the thread are listed with the list thread emails endpoint.

```php
Resend::inboxes()->getThread(string $inboxId, string $threadId): Response
```

`$response->dto()` returns an `InboxThread`.

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$threadId` (`string`, required, path `thread_id`) The Thread ID.

## `updateThread()`

`PATCH /inboxes/{inbox_id}/threads/{thread_id}` – Update an existing inbox thread

Marks a thread read or unread, or moves it to a folder. At least one of `read` or `folder` is required. To change the labels of a thread, use the add, set, and remove thread labels endpoints. This endpoint ignores the removed `add_label_ids` and `remove_label_ids` fields, so a body with only those fields returns a 422 validation_error. Moving a thread out of `trash` restores it and clears its deletion deadline. The changes apply in this order: `read`, then `folder`. They are not atomic.

```php
Resend::inboxes()->updateThread(
    string $inboxId,
    string $threadId,
    ?bool $read = null,
    ?string $folder = null,
): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$threadId` (`string`, required, path `thread_id`) The Thread ID.
- `$read` (`bool|null`) Marks every email in the thread read or unread.
- `$folder` (`'inbox'|'archive'|'spam'|'trash'|null`) Moves the thread to this folder. `sent` is assigned automatically and cannot be set.

## `removeThread()`

`DELETE /inboxes/{inbox_id}/threads/{thread_id}` – Remove an existing inbox thread

Moves the thread to `trash` and schedules it for deletion in 30 days. This is reversible. To restore the thread, update its `folder` to `inbox`, `archive`, or `spam`, which also clears the deletion deadline.

```php
Resend::inboxes()->removeThread(string $inboxId, string $threadId): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$threadId` (`string`, required, path `thread_id`) The Thread ID.

## `addThreadLabels()`

`POST /inboxes/{inbox_id}/threads/{thread_id}/labels` – Add labels to an inbox thread

Applies one or more labels to the thread. Labels already on the thread stay on it. The response lists every label on the thread after the change. A label ID that is not a label of the inbox returns a 404 `Label not found.`, and nothing changes. A thread that does not exist in the inbox returns a 404 `Thread not found.`. To replace the labels of the thread, use the set thread labels endpoint.

```php
Resend::inboxes()->addThreadLabels(string $inboxId, string $threadId, array $labels): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$threadId` (`string`, required, path `thread_id`) The Thread ID.
- `$labels` (`list<string>`, required) The IDs of the labels to apply to the thread. Between 1 and 10 IDs, each a label of the inbox.

## `setThreadLabels()`

`PUT /inboxes/{inbox_id}/threads/{thread_id}/labels` – Set the labels of an inbox thread

Replaces every label on the thread with the given labels, in one atomic change. Labels on the thread that are not in the list are taken off it. The labels themselves are kept. An empty array takes every label off the thread. The response lists every label on the thread after the change. A label ID that is not a label of the inbox returns a 404 `Label not found.`, and nothing changes. A thread that does not exist in the inbox returns a 404 `Thread not found.`.

```php
Resend::inboxes()->setThreadLabels(string $inboxId, string $threadId, array $labels): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$threadId` (`string`, required, path `thread_id`) The Thread ID.
- `$labels` (`list<string>`, required) The IDs of the labels the thread carries after the change. Up to 100 IDs, each a label of the inbox. Pass an empty array to take every label off the thread.

## `removeThreadLabel()`

`DELETE /inboxes/{inbox_id}/threads/{thread_id}/labels/{label_id}` – Remove a label from an inbox thread

Takes one label off the thread. The label itself is kept, and stays on every other thread that carries it. To delete the label, use the remove inbox label endpoint. The response lists every label on the thread after the change. A label that is not on the thread returns a 200 with the current labels. A label ID that is not a label of the inbox returns a 404 `Label not found.`. A thread that does not exist in the inbox returns a 404 `Thread not found.`.

```php
Resend::inboxes()->removeThreadLabel(string $inboxId, string $threadId, string $labelId): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$threadId` (`string`, required, path `thread_id`) The Thread ID.
- `$labelId` (`string`, required, path `label_id`) The Label ID.

## `listThreadEmails()`

`GET /inboxes/{inbox_id}/threads/{thread_id}/emails` – Retrieve a list of thread emails

Returns the messages of a thread, oldest first. Pass the `id` of the last message as `after` to get the next, newer page. Pass the `id` of the first message as `before` to get the previous, older page. Passing both `after` and `before`, or a cursor that is not a UUID, returns a 422. A cursor that is not a message of the thread returns a 404.

```php
Resend::inboxes()->listThreadEmails(
    string $inboxId,
    string $threadId,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

`$response->dto()` returns a `ListResponse` of `InboxThreadEmail`.

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$threadId` (`string`, required, path `thread_id`) The Thread ID.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `getThreadEmail()`

`GET /inboxes/{inbox_id}/threads/{thread_id}/emails/{email_id}` – Retrieve a single thread email

```php
Resend::inboxes()->getThreadEmail(string $inboxId, string $threadId, string $emailId): Response
```

`$response->dto()` returns an `InboxThreadEmail`.

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$threadId` (`string`, required, path `thread_id`) The Thread ID.
- `$emailId` (`string`, required, path `email_id`) The Email ID, as returned in `data[].id` by the list thread emails endpoint.

## `replyThreadEmail()`

`POST /inboxes/{inbox_id}/threads/{thread_id}/emails/{email_id}/reply` – Reply to a thread email

Sends a reply from the inbox address right away, with no stored draft. The `to` recipients come from the message you reply to. For a message the inbox received, the reply goes to its `Reply-To` addresses, or to its sender when it has no `Reply-To`. For a message the inbox sent, the reply goes to that message's `to` recipients. Set `reply_all` to also copy the other recipients of the message. The reply threads under the message through the `In-Reply-To` and `References` headers. When no recipient can be found for the reply, the request returns a 422. The whole email, encoded, can be at most 40 MB, or the request returns a 422.

```php
Resend::inboxes()->replyThreadEmail(
    string $inboxId,
    string $threadId,
    string $emailId,
    string|array|Omit|null $cc = Omit::Value,
    string|array|Omit|null $bcc = Omit::Value,
    ?string $html = null,
    ?string $text = null,
    ?string $subject = null,
    ?bool $replyAll = null,
    array|Omit|null $attachments = Omit::Value,
    array|Omit|null $customHeaders = Omit::Value,
    ?string $idempotencyKey = null,
): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$threadId` (`string`, required, path `thread_id`) The Thread ID.
- `$emailId` (`string`, required, path `email_id`) The Email ID of the message to reply to, as returned in `data[].id` by the list thread emails endpoint.
- `$cc` (`string|list<string>|null|Omit`) CC recipient email address. For multiple addresses, send as an array of strings. Without `reply_all`, the reply copies only these addresses. With `reply_all`, these addresses are merged with the copied recipients, without duplicates. `cc` and `bcc` combined must be fewer than 50 addresses. After the `to` recipients are added, the reply cannot exceed 50 recipients. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
- `$bcc` (`string|list<string>|null|Omit`) BCC recipient email address. For multiple addresses, send as an array of strings. BCC recipients of the original message are never copied. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
- `$html` (`string|null`) The HTML body of the reply.
- `$text` (`string|null`) The plain-text body of the reply.
- `$subject` (`string|null`) The subject of the reply. Cannot be only whitespace or contain a line break. When omitted, the thread subject is used, prefixed with `Re:` if it does not already start with it.
- `$replyAll` (`bool|null`, field `reply_all`) Reply to everyone on the original message. For a message the inbox received, the reply goes to its `Reply-To` addresses, or to its sender when it has none, and copies the other addresses of its `To` header and its `cc` recipients in `cc`. For a message the inbox sent, the reply goes to that message's `Reply-To` addresses when they are not the inbox address, otherwise to its `to` recipients, and copies its `cc` recipients. The inbox address is always excluded, and duplicates are removed.
- `$attachments` (`list<array{content?: string, filename?: string, path?: string, content_type?: string, content_id?: string}>|null|Omit`) Files to attach, as on `POST /emails`. Each one needs `content` or `path`. The `content` of all files can total at most 25 MB. A `path` file does not count toward the 25 MB, because it is fetched when the email is sent. An empty file, a blocked file type, a `path` that does not start with `http` or that starts with `http://localhost:`, or a `content_type` that is not a valid MIME type returns a 422. Other `path` problems fail the email when it is sent, not the request.
- `$customHeaders` (`array<string, mixed>|null|Omit`, field `headers`) Custom headers to add to the email. The `In-Reply-To`, `References` and `Reply-To` headers are set by Resend and cannot be set here. Sending one of them, in any letter case, returns a 422. Header names cannot be empty, and names and values cannot contain line breaks or null characters, or the request returns a 422. `null` means no custom headers.
- `$idempotencyKey` (`string|null`, header `Idempotency-Key`) A unique key for the request, so the reply is sent only once. A retry with the same key within 24 hours returns the first successful (2xx) response, with the `idempotent-replayed: true` header. A failed request is not stored, so it can be retried with the same key. Reusing the key with a different body, or while the first request is still running, returns a 409. An empty key, or one longer than 256 characters, returns a 400 `invalid_idempotency_key`. [Learn more](https://resend.com/docs/dashboard/emails/idempotency-keys)

## `forwardThreadEmail()`

`POST /inboxes/{inbox_id}/threads/{thread_id}/emails/{email_id}/forward` – Forward a thread email

Forwards a message from the inbox address right away, with no stored draft. The original message is quoted under a forwarded-message banner, below the optional `html` or `text` note. The attachments of the original message are sent with the forward, together with any `attachments` you add. The request returns a 422 when they exceed 25 MB of `content` in total. An original attachment that was sent from a URL (`path`) cannot be forwarded, and the request returns a 422. The whole email, encoded, can be at most 40 MB, or the request returns a 422.

```php
Resend::inboxes()->forwardThreadEmail(
    string $inboxId,
    string $threadId,
    string $emailId,
    string|array $to,
    string|array|Omit|null $cc = Omit::Value,
    string|array|Omit|null $bcc = Omit::Value,
    ?string $html = null,
    ?string $text = null,
    ?string $subject = null,
    array|Omit|null $attachments = Omit::Value,
    array|Omit|null $customHeaders = Omit::Value,
    ?string $idempotencyKey = null,
): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$threadId` (`string`, required, path `thread_id`) The Thread ID.
- `$emailId` (`string`, required, path `email_id`) The Email ID of the message to forward, as returned in `data[].id` by the list thread emails endpoint.
- `$to` (`string|list<string>`, required) Recipient email address. For multiple addresses, send as an array of strings. Must name at least one address. `to`, `cc` and `bcc` combined cannot exceed 50 recipients. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
- `$cc` (`string|list<string>|null|Omit`) CC recipient email address. For multiple addresses, send as an array of strings. Counts toward the 50-recipient limit. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
- `$bcc` (`string|list<string>|null|Omit`) BCC recipient email address. For multiple addresses, send as an array of strings. Counts toward the 50-recipient limit. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
- `$html` (`string|null`) An HTML note sent above the quoted original.
- `$text` (`string|null`) A plain-text note sent above the quoted original.
- `$subject` (`string|null`) The subject of the forward. Cannot be only whitespace or contain a line break. When omitted, the thread subject is used, prefixed with `Fwd:` if it does not already start with it.
- `$attachments` (`list<array{content?: string, filename?: string, path?: string, content_type?: string, content_id?: string}>|null|Omit`) Files to attach, as on `POST /emails`. Each one needs `content` or `path`. They share one limit with the attachments of the original message, which the forward also sends. Together they can have at most 25 MB of `content`. A `path` file does not count toward the 25 MB, because it is fetched when the email is sent. An empty file, a blocked file type, a `path` that does not start with `http` or that starts with `http://localhost:`, or a `content_type` that is not a valid MIME type returns a 422. Other `path` problems fail the email when it is sent, not the request.
- `$customHeaders` (`array<string, mixed>|null|Omit`, field `headers`) Custom headers to add to the email. The `In-Reply-To`, `References` and `Reply-To` headers are set by Resend and cannot be set here. Sending one of them, in any letter case, returns a 422. Header names cannot be empty, and names and values cannot contain line breaks or null characters, or the request returns a 422. `null` means no custom headers.
- `$idempotencyKey` (`string|null`, header `Idempotency-Key`) A unique key for the request, so the forward is sent only once. A retry with the same key within 24 hours returns the first successful (2xx) response, with the `idempotent-replayed: true` header. A failed request is not stored, so it can be retried with the same key. Reusing the key with a different body, or while the first request is still running, returns a 409. An empty key, or one longer than 256 characters, returns a 400 `invalid_idempotency_key`. [Learn more](https://resend.com/docs/dashboard/emails/idempotency-keys)

## `listDrafts()`

`GET /inboxes/{inbox_id}/drafts` – Retrieve a list of drafts

Returns the unsent drafts on the inbox, most recently updated first. The `after` and `before` cursors take a Draft ID from the current page, and only one of them can be passed. A cursor that is not a UUID, or both cursors together, return a 422. A cursor that is not an unsent draft on this inbox returns a 404.

```php
Resend::inboxes()->listDrafts(
    string $inboxId,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

`$response->dto()` returns a `ListResponse` of `InboxDraft`.

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `createDraft()`

`POST /inboxes/{inbox_id}/drafts` – Create a draft

Creates an unsent draft on the inbox. Omit `thread_id` and `reply_to_email_id` for a draft that starts a new thread. Pass both together for a reply draft in an existing thread. A reply draft without `to` is addressed to the sender of the email it replies to, or to its Reply-To when set. For an email the inbox sent, it defaults to that email's `to` recipients. Send `to: []` to leave it empty. At least one of `to`, `cc`, `bcc`, `subject`, `text`, `html` or `attachments` must be non-empty. The combined recipients of `to`, `cc` and `bcc` cannot exceed 50. Attachments are stored on the draft, so each one needs `content`, `filename` and `content_type`. Returns 201 for a new draft. Only one unsent reply draft can target an email, so a reply draft request for an email that already has one returns 200 with the ID of the existing draft. An unknown `thread_id`, or a `reply_to_email_id` that is not in that thread, returns a 404. That request ignores every other field, except `attachments`, which replaces the attachments of the existing draft when sent. A reply draft created without `subject` stores an empty subject. When it is sent, it takes the thread subject, prefixed with `Re:` when it does not already start with it.

```php
Resend::inboxes()->createDraft(
    string $inboxId,
    string|array|Omit|null $to = Omit::Value,
    string|array|Omit|null $cc = Omit::Value,
    string|array|Omit|null $bcc = Omit::Value,
    string|Omit|null $subject = Omit::Value,
    string|Omit|null $html = Omit::Value,
    string|Omit|null $text = Omit::Value,
    array|Omit|null $attachments = Omit::Value,
    ?string $threadId = null,
    ?string $replyToEmailId = null,
    ?string $idempotencyKey = null,
): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$to` (`string|list<string>|null|Omit`) The recipients. For multiple addresses, send an array of strings. Each value can include a friendly name, for example `Ada Lovelace <ada@example.org>`. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
- `$cc` (`string|list<string>|null|Omit`) The CC recipients. For multiple addresses, send an array of strings. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
- `$bcc` (`string|list<string>|null|Omit`) The BCC recipients. For multiple addresses, send an array of strings. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
- `$subject` (`string|null|Omit`) The subject. Max 2000 characters. A string that is only whitespace, or that contains a line break, is rejected.
- `$html` (`string|null|Omit`) The HTML body.
- `$text` (`string|null|Omit`) The plain text body.
- `$attachments` (`list<array{content: string, filename: string, content_type: string}>|null|Omit`) Files to store on the draft. Each one needs `content`, `filename` and `content_type`. A `path` without `content` returns a 422, and when both are sent, `path` is ignored. A `content_id` returns a 422. The files on a draft can total at most 25 MB. An empty file or a blocked file type returns a 422.
- `$threadId` (`string|null`, field `thread_id`) The Thread ID to reply in. Must be sent with `reply_to_email_id`.
- `$replyToEmailId` (`string|null`, field `reply_to_email_id`) The Email ID to reply to, as returned in `data[].id` by the list thread emails endpoint. Must be sent with `thread_id`.
- `$idempotencyKey` (`string|null`, header `Idempotency-Key`) A unique key for the request, so the draft is created only once. A retry with the same key within 24 hours returns the first successful (2xx) response, with the `idempotent-replayed: true` header. A failed request is not stored, so it can be retried with the same key. Reusing the key with a different body, or while the first request is still running, returns a 409. An empty key, or one longer than 256 characters, returns a 400 `invalid_idempotency_key`. [Learn more](https://resend.com/docs/dashboard/emails/idempotency-keys)

## `getDraft()`

`GET /inboxes/{inbox_id}/drafts/{draft_id}` – Retrieve a single draft

```php
Resend::inboxes()->getDraft(string $inboxId, string $draftId): Response
```

`$response->dto()` returns an `InboxDraft`.

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$draftId` (`string`, required, path `draft_id`) The Draft ID.

## `updateDraft()`

`PATCH /inboxes/{inbox_id}/drafts/{draft_id}` – Update an existing draft

Updates the content of an unsent draft. Omitted fields are left unchanged. Send at least one of `to`, `cc`, `bcc`, `subject`, `text`, `html` or `attachments`. Sending `attachments` replaces every attachment on the draft. A request that sets `text` or `html` replaces the whole body. The body part you omit from that request becomes `null`. The merged draft must still contain at least one non-empty field, and its combined recipients cannot exceed 50. A draft that was already sent, or that changed during the request, returns a 409. The response holds only the Draft ID. Retrieve the draft to read its content.

```php
Resend::inboxes()->updateDraft(
    string $inboxId,
    string $draftId,
    string|array|Omit|null $to = Omit::Value,
    string|array|Omit|null $cc = Omit::Value,
    string|array|Omit|null $bcc = Omit::Value,
    string|Omit|null $subject = Omit::Value,
    string|Omit|null $html = Omit::Value,
    string|Omit|null $text = Omit::Value,
    array|Omit|null $attachments = Omit::Value,
): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$draftId` (`string`, required, path `draft_id`) The Draft ID.
- `$to` (`string|list<string>|null|Omit`) The recipients. For multiple addresses, send an array of strings. Each value can include a friendly name. Pass `null` to clear. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
- `$cc` (`string|list<string>|null|Omit`) The CC recipients. Pass `null` or `[]` to clear. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
- `$bcc` (`string|list<string>|null|Omit`) The BCC recipients. Pass `null` or `[]` to clear. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
- `$subject` (`string|null|Omit`) The subject. Max 2000 characters. Cannot be only whitespace or contain a line break. Pass `null` to clear.
- `$html` (`string|null|Omit`) The HTML body. Pass `null` to clear.
- `$text` (`string|null|Omit`) The plain text body. Pass `null` to clear.
- `$attachments` (`list<array{content: string, filename: string, content_type: string}>|null|Omit`) Files to store on the draft. Each one needs `content`, `filename` and `content_type`. A `path` without `content` returns a 422, and when both are sent, `path` is ignored. A `content_id` returns a 422. The files on a draft can total at most 25 MB. An empty file or a blocked file type returns a 422. Sending the field replaces every attachment on the draft. Send `[]` to remove them all. `null` also removes them all.

## `removeDraft()`

`DELETE /inboxes/{inbox_id}/drafts/{draft_id}` – Remove an existing draft

Discards an unsent draft. A draft that was already sent, or that changed during the request, returns a 409.

```php
Resend::inboxes()->removeDraft(string $inboxId, string $draftId): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$draftId` (`string`, required, path `draft_id`) The Draft ID.

## `sendDraft()`

`POST /inboxes/{inbox_id}/drafts/{draft_id}/send` – Send a draft

Sends the draft from the inbox address. A reply draft is sent in its thread. A draft without a thread starts a new thread. The draft must have at least one `to` recipient and `html` or `text`, or the request returns a 422. A standalone draft also needs a non-empty `subject`. A reply draft with an empty `subject` is sent with the thread subject, prefixed with `Re:` when it does not already start with it. A draft that was already sent returns a 409. The request body is optional and takes only `headers`. The whole email, encoded, can be at most 40 MB, or the request returns a 422.

```php
Resend::inboxes()->sendDraft(
    string $inboxId,
    string $draftId,
    array|Omit|null $customHeaders = Omit::Value,
    ?string $idempotencyKey = null,
): Response
```

- `$inboxId` (`string`, required, path `inbox_id`) The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
- `$draftId` (`string`, required, path `draft_id`) The Draft ID.
- `$customHeaders` (`array<string, mixed>|null|Omit`, field `headers`) Custom headers to add to the email. The `In-Reply-To`, `References` and `Reply-To` headers are set by Resend and cannot be set here. Sending one of them, in any letter case, returns a 422. Header names cannot be empty, and names and values cannot contain line breaks or null characters, or the request returns a 422. `null` means no custom headers.
- `$idempotencyKey` (`string|null`, header `Idempotency-Key`) A unique key for the request, so the draft is sent only once. A retry with the same key within 24 hours returns the first successful (2xx) response, with the `idempotent-replayed: true` header. A failed request is not stored, so it can be retried with the same key. Reusing the key with a different body, or while the first request is still running, returns a 409. An empty key, or one longer than 256 characters, returns a 400 `invalid_idempotency_key`. [Learn more](https://resend.com/docs/dashboard/emails/idempotency-keys)
