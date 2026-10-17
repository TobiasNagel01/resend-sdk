# DTOs

Readonly classes in `TobiasNagel01\ResendSdk\Data`, returned by `$response->dto()`. List endpoints return a `TobiasNagel01\ResendSdk\Data\ListResponse` with `data` (list of DTOs), `hasMore` and `nextCursor()`. Every DTO can also be built from a raw API payload with `::fromArray(array $data)`.

## `Email`

- `$object` (`string|null`, key `object`) The type of object.
- `$id` (`string|null`, key `id`) The ID of the email.
- `$messageId` (`string|null`, key `message_id`) The Message-ID header value of the email.
- `$to` (`list<string>|null`, key `to`)
- `$from` (`string|null`, key `from`) The email address of the sender.
- `$createdAt` (`string|null`, key `created_at`) The date and time the email was created.
- `$subject` (`string|null`, key `subject`) The subject line of the email.
- `$html` (`string|null`, key `html`) The HTML body of the email.
- `$text` (`string|null`, key `text`) The plain text body of the email.
- `$bcc` (`list<string>|null`, key `bcc`) The email addresses of the blind carbon copy recipients.
- `$cc` (`list<string>|null`, key `cc`) The email addresses of the carbon copy recipients.
- `$replyTo` (`list<string>|null`, key `reply_to`) The email addresses to which replies should be sent.
- `$lastEvent` (`'bounced'|'canceled'|'clicked'|'complained'|'delivered'|'delivery_delayed'|'failed'|'opened'|'queued'|'scheduled'|'sent'|'suppressed'|null`, key `last_event`) The status of the email.

## `Attachment`

- `$id` (`string|null`, key `id`) The ID of the attachment.
- `$filename` (`string|null`, key `filename`) The filename of the attachment.
- `$contentType` (`string|null`, key `content_type`) The MIME type of the attachment.
- `$contentId` (`string|null`, key `content_id`) The content ID for inline attachments.
- `$contentDisposition` (`'inline'|'attachment'|null`, key `content_disposition`) How the attachment should be displayed.
- `$downloadUrl` (`string|null`, key `download_url`) Signed URL to download the attachment content.
- `$expiresAt` (`string|null`, key `expires_at`) Timestamp when the download URL expires.
- `$size` (`int|null`, key `size`) Size of the attachment in bytes.
- `$object` (`string|null`, key `object`) The type of object.

## `ReceivedEmail`

- `$id` (`string|null`, key `id`) The ID of the received email.
- `$to` (`list<string>|null`, key `to`) The recipient email addresses.
- `$from` (`string|null`, key `from`) The sender email address.
- `$subject` (`string|null`, key `subject`) The email subject.
- `$messageId` (`string|null`, key `message_id`) The unique message ID from the email headers.
- `$bcc` (`list<string>|null`, key `bcc`) The BCC recipients.
- `$cc` (`list<string>|null`, key `cc`) The CC recipients.
- `$replyTo` (`list<string>|null`, key `reply_to`) The reply-to addresses.
- `$createdAt` (`string|null`, key `created_at`) Timestamp when the email was received.
- `$attachments` (`list<array{id?: string, filename?: string, content_type?: string, content_id?: string, content_disposition?: 'inline'|'attachment', size?: int}>|null`, key `attachments`) Array of attachments for this email.
- `$object` (`string|null`, key `object`) The type of object.
- `$receivedFor` (`list<string>|null`, key `received_for`) The recipient addresses the email was forwarded for, taken from the `for` clause of the message's `Received` headers.
- `$html` (`string|null`, key `html`) The HTML content of the email.
- `$text` (`string|null`, key `text`) The plain text content of the email.
- `$headers` (`array<string, mixed>|null`, key `headers`) The email headers.

## `Domain`

- `$id` (`string|null`, key `id`) The ID of the domain.
- `$name` (`string|null`, key `name`) The name of the domain.
- `$status` (`'pending'|'verified'|'failed'|'not_started'|'partially_verified'|'partially_failed'|null`, key `status`) The status of the domain.
- `$createdAt` (`string|null`, key `created_at`) The date and time the domain was created.
- `$region` (`string|null`, key `region`) The region where the domain is hosted.
- `$openTracking` (`bool|null`, key `open_tracking`) Whether open tracking is enabled for this domain.
- `$clickTracking` (`bool|null`, key `click_tracking`) Whether click tracking is enabled for this domain.
- `$capabilities` (`array{sending?: 'enabled'|'disabled', receiving?: 'enabled'|'disabled'}|null`, key `capabilities`) Configure the domain capabilities for sending and receiving emails. At least one capability must be enabled.
- `$object` (`string|null`, key `object`) The type of object.
- `$trackingSubdomain` (`string|null`, key `tracking_subdomain`) The subdomain used for click and open tracking.
- `$records` (`list<DomainRecord>|null`, key `records`)

## `DomainRecord`

- `$record` (`'SPF'|'DKIM'|'Receiving'|'Tracking'|'TrackingCAA'|null`, key `record`) The type of record (SPF for sending, DKIM for sending, Receiving for inbound emails, Tracking & TrackingCAA for click and open tracking).
- `$name` (`string|null`, key `name`) The name of the DNS record.
- `$type` (`'MX'|'TXT'|'CNAME'|'CAA'|null`, key `type`) The DNS record type.
- `$ttl` (`string|null`, key `ttl`) The time to live for the record.
- `$status` (`'pending'|'verified'|'failed'|'temporary_failure'|'not_started'|null`, key `status`) The status of the record.
- `$value` (`string|null`, key `value`) The value of the record.
- `$priority` (`int|null`, key `priority`) The priority of the record (only applicable for MX records).

## `DomainClaim`

- `$object` (`string|null`, key `object`) The type of object.
- `$id` (`string|null`, key `id`) The ID of the claim.
- `$name` (`string|null`, key `name`) The name of the domain being claimed.
- `$status` (`'pending'|'verified'|'completed'|'blocked'|'expired'|'superseded'|'canceled'|'failed'|null`, key `status`) The status of the claim.
- `$domainId` (`string|null`, key `domain_id`) The ID of the placeholder domain created for the claim.
- `$region` (`'us-east-1'|'eu-west-1'|'sa-east-1'|'ap-northeast-1'|null`, key `region`) The region where the claimed domain will send from.
- `$record` (`array{type?: 'TXT', name?: string, value?: string, ttl?: string}|null`, key `record`) The TXT record to add to your DNS to prove ownership of the claimed domain.
- `$blockedReason` (`'grace_period'|'recent_owner_activity'|'pending_scheduled_emails'|null`, key `blocked_reason`) Why the claim is currently blocked, if applicable.
- `$failureReason` (`string|null`, key `failure_reason`) Why the claim failed, if applicable.
- `$createdAt` (`string|null`, key `created_at`) The date and time the claim was created.
- `$expiresAt` (`string|null`, key `expires_at`) The date and time the claim expires if not verified.

## `ApiKey`

- `$id` (`string|null`, key `id`) The ID of the API key.
- `$name` (`string|null`, key `name`) The name of the API key.
- `$createdAt` (`string|null`, key `created_at`) The date and time the API key was created.
- `$lastUsedAt` (`string|null`, key `last_used_at`) The date and time the API key was last used.

## `OAuthGrant`

- `$id` (`string|null`, key `id`) The ID of the OAuth grant.
- `$clientId` (`string|null`, key `client_id`) The ID of the OAuth client the grant was issued to.
- `$scopes` (`list<string>|null`, key `scopes`) The scopes granted to the OAuth client.
- `$createdAt` (`string|null`, key `created_at`) The date and time the OAuth grant was created.
- `$revokedAt` (`string|null`, key `revoked_at`) The date and time the OAuth grant was revoked, or null if it is still active.
- `$revokedReason` (`string|null`, key `revoked_reason`) The reason the OAuth grant was revoked, or null if it is still active.
- `$client` (`array{name?: string, logo_uri?: string}|null`, key `client`) The OAuth client the grant was issued to.

## `Template`

- `$id` (`string|null`, key `id`) The ID of the template.
- `$name` (`string|null`, key `name`) The name of the template.
- `$status` (`'draft'|'published'|null`, key `status`) The publication status of the template.
- `$publishedAt` (`string|null`, key `published_at`) Timestamp indicating when the template was published.
- `$createdAt` (`string|null`, key `created_at`) Timestamp indicating when the template was created.
- `$updatedAt` (`string|null`, key `updated_at`) Timestamp indicating when the template was last updated.
- `$alias` (`string|null`, key `alias`) The alias of the template.
- `$object` (`string|null`, key `object`) The type of object.
- `$currentVersionId` (`string|null`, key `current_version_id`) The ID of the current version of the template.
- `$from` (`string|null`, key `from`) Sender email address. To include a friendly name, use the format "Your Name <sender@domain.com>".
- `$subject` (`string|null`, key `subject`) Email subject.
- `$replyTo` (`list<string>|null`, key `reply_to`) Reply-to email addresses.
- `$html` (`string|null`, key `html`) The HTML version of the template.
- `$text` (`string|null`, key `text`) The plain text version of the template.
- `$variables` (`list<TemplateVariable>|null`, key `variables`)
- `$hasUnpublishedVersions` (`bool|null`, key `has_unpublished_versions`) Indicates whether the template has unpublished versions.

## `TemplateVariable`

- `$key` (`string`, key `key`) The key of the variable.
- `$type` (`'string'|'number'|'boolean'|'object'|'list'`, key `type`) The type of the variable.
- `$id` (`string|null`, key `id`) The ID of the template variable.
- `$fallbackValue` (`string|int|float|bool|array<string, mixed>|list<mixed>|null`, key `fallback_value`) The fallback value of the variable.
- `$createdAt` (`string|null`, key `created_at`) Timestamp indicating when the variable was created.
- `$updatedAt` (`string|null`, key `updated_at`) Timestamp indicating when the variable was last updated.

## `Audience`

- `$id` (`string|null`, key `id`) Unique identifier for the audience.
- `$name` (`string|null`, key `name`) Name of the audience.
- `$createdAt` (`string|null`, key `created_at`) Timestamp indicating when the audience was created.
- `$object` (`string|null`, key `object`) The object of the audience.

## `Contact`

- `$id` (`string|null`, key `id`) Unique identifier for the contact.
- `$email` (`string|null`, key `email`) Email address of the contact.
- `$firstName` (`string|null`, key `first_name`) First name of the contact.
- `$lastName` (`string|null`, key `last_name`) Last name of the contact.
- `$createdAt` (`string|null`, key `created_at`) Timestamp indicating when the contact was created.
- `$unsubscribed` (`bool|null`, key `unsubscribed`) Indicates if the contact is unsubscribed.
- `$object` (`string|null`, key `object`) Type of the response object.
- `$properties` (`array<string, mixed>|null`, key `properties`) A map of custom property keys and values.

## `ContactImport`

- `$object` (`string|null`, key `object`) Type of the response object.
- `$id` (`string|null`, key `id`) Unique identifier for the contact import.
- `$status` (`'queued'|'in_progress'|'completed'|'failed'|null`, key `status`) Current status of the contact import.
- `$createdAt` (`string|null`, key `created_at`) Timestamp indicating when the contact import was created.
- `$completedAt` (`string|null`, key `completed_at`) Timestamp indicating when the contact import completed.
- `$counts` (`array{total?: int, created?: int, updated?: int, skipped?: int, failed?: int}|null`, key `counts`)

## `ContactProperty`

- `$id` (`string|null`, key `id`) Unique identifier for the contact property.
- `$key` (`string|null`, key `key`) The property key.
- `$type` (`string|null`, key `type`) The property type.
- `$fallbackValue` (`string|int|float|null`, key `fallback_value`) The default value when the property is not set for a contact.
- `$createdAt` (`string|null`, key `created_at`) Timestamp indicating when the contact property was created.
- `$object` (`string|null`, key `object`) The object type.

## `Broadcast`

- `$id` (`string|null`, key `id`) Unique identifier for the broadcast.
- `$name` (`string|null`, key `name`) Name of the broadcast.
- `$audienceId` (`string|null`, key `audience_id`) Deprecated. Use segment_id instead.
- `$segmentId` (`string|null`, key `segment_id`) Unique identifier of the segment this broadcast will be sent to.
- `$status` (`string|null`, key `status`) The status of the broadcast.
- `$createdAt` (`string|null`, key `created_at`) Timestamp indicating when the broadcast was created.
- `$scheduledAt` (`string|null`, key `scheduled_at`) Timestamp indicating when the broadcast is scheduled to be sent.
- `$sentAt` (`string|null`, key `sent_at`) Timestamp indicating when the broadcast was sent.
- `$topicId` (`string|null`, key `topic_id`) The topic ID that the broadcast is scoped to.
- `$from` (`string|null`, key `from`) The email address of the sender.
- `$subject` (`string|null`, key `subject`) The subject line of the email.
- `$replyTo` (`list<string>|null`, key `reply_to`) The email addresses to which replies should be sent.
- `$previewText` (`string|null`, key `preview_text`) The preview text of the email.
- `$text` (`string|null`, key `text`) The plain text version of the broadcast content.
- `$html` (`string|null`, key `html`) The HTML version of the broadcast content.

## `Webhook`

- `$id` (`string|null`, key `id`) The ID of the webhook.
- `$endpoint` (`string|null`, key `endpoint`) The URL where webhook events are sent.
- `$events` (`list<string>|null`, key `events`) Array of event types subscribed to.
- `$status` (`string|null`, key `status`) The status of the webhook.
- `$createdAt` (`string|null`, key `created_at`) Timestamp indicating when the webhook was created.
- `$object` (`string|null`, key `object`) The type of object.
- `$signingSecret` (`string|null`, key `signing_secret`) The secret key used to verify webhook payloads.

## `WebhookEvent`

- `$id` (`string|null`, key `id`) The ID of the webhook event.
- `$type` (`string|null`, key `type`) The type of the event.
- `$createdAt` (`string|null`, key `created_at`) Timestamp indicating when the event was created.
- `$status` (`'pending'|'attempting'|'success'|'failed'|null`, key `status`) The delivery status of the event for this webhook.
- `$object` (`string|null`, key `object`) The type of object.
- `$nextAttemptAt` (`string|null`, key `next_attempt_at`) Timestamp of the next scheduled delivery attempt, or null when none is scheduled. Always null once the event has succeeded or permanently failed.
- `$payload` (`array<string, mixed>|null`, key `payload`) The event payload sent to the webhook endpoint.

## `Segment`

- `$id` (`string|null`, key `id`) Unique identifier for the segment.
- `$name` (`string|null`, key `name`) Name of the segment.
- `$audienceId` (`string|null`, key `audience_id`) The ID of the audience this segment belongs to.
- `$createdAt` (`string|null`, key `created_at`) Timestamp indicating when the segment was created.
- `$object` (`string|null`, key `object`) The object type.
- `$filter` (`array<string, mixed>|null`, key `filter`) Filter conditions for the segment.

## `Topic`

- `$id` (`string|null`, key `id`) Unique identifier for the topic.
- `$name` (`string|null`, key `name`) Name of the topic.
- `$description` (`string|null`, key `description`) A description of the topic.
- `$defaultSubscription` (`'opt_in'|'opt_out'|null`, key `default_subscription`) The default subscription status for the topic.
- `$visibility` (`'public'|'private'|null`, key `visibility`) The visibility of the topic.
- `$createdAt` (`string|null`, key `created_at`) Timestamp indicating when the topic was created.
- `$object` (`string|null`, key `object`) The object type.

## `Log`

- `$id` (`string|null`, key `id`) The log ID.
- `$createdAt` (`string|null`, key `created_at`) The date the log was created.
- `$endpoint` (`string|null`, key `endpoint`) The API endpoint that was called.
- `$method` (`'GET'|'POST'|'PUT'|'DELETE'|'PATCH'|'OPTIONS'|null`, key `method`) The HTTP method used.
- `$responseStatus` (`int|null`, key `response_status`) The HTTP status code of the response.
- `$userAgent` (`string|null`, key `user_agent`) The user agent of the request.
- `$object` (`string|null`, key `object`) Type of the response object.
- `$requestBody` (`array<string, mixed>|null`, key `request_body`) The request body sent to the API.
- `$responseBody` (`array<string, mixed>|null`, key `response_body`) The response body returned by the API.

## `Automation`

- `$id` (`string|null`, key `id`) The ID of the automation.
- `$name` (`string|null`, key `name`) The name of the automation.
- `$status` (`'enabled'|'disabled'|null`, key `status`) The current status of the automation.
- `$createdAt` (`string|null`, key `created_at`) The date and time the automation was created.
- `$updatedAt` (`string|null`, key `updated_at`) The date and time the automation was last updated.
- `$object` (`string|null`, key `object`) Type of the response object.
- `$steps` (`list<array{key?: string, type?: 'trigger'|'send_email'|'delay'|'wait_for_event'|'condition'|'contact_update'|'contact_delete'|'add_to_segment', config?: array<string, mixed>}>|null`, key `steps`) The steps in the active version of the automation.
- `$connections` (`list<array{from: string, to: string, type?: 'default'|'condition_met'|'condition_not_met'|'timeout'|'event_received'}>|null`, key `connections`) The connections between steps in the active version of the automation.

## `AutomationRun`

- `$id` (`string|null`, key `id`) The ID of the automation run.
- `$status` (`'running'|'completed'|'failed'|'cancelled'|null`, key `status`) The current status of the automation run.
- `$startedAt` (`string|null`, key `started_at`) The date and time the run started.
- `$completedAt` (`string|null`, key `completed_at`) The date and time the run completed.
- `$createdAt` (`string|null`, key `created_at`) The date and time the run was created.
- `$object` (`string|null`, key `object`) Type of the response object.
- `$steps` (`list<array{key?: string, type?: 'trigger'|'send_email'|'delay'|'wait_for_event'|'condition'|'contact_update'|'contact_delete'|'add_to_segment', status?: string, started_at?: string, completed_at?: string, output?: array<string, mixed>, error?: array<string, mixed>, created_at?: string}>|null`, key `steps`) The steps executed in this run, sorted in graph order.

## `Event`

- `$id` (`string|null`, key `id`) The event ID.
- `$name` (`string|null`, key `name`) The event name.
- `$schema` (`array<string, mixed>|null`, key `schema`) A flat key/type map defining the event payload schema. Supported types are `string`, `number`, `boolean`, and `date`.
- `$createdAt` (`string|null`, key `created_at`) The date and time the event was created.
- `$updatedAt` (`string|null`, key `updated_at`) The date and time the event was last updated.
- `$object` (`string|null`, key `object`) Type of the response object.

## `Suppression`

- `$id` (`string|null`, key `id`) Unique identifier for the suppression.
- `$email` (`string|null`, key `email`) Email address that is suppressed.
- `$origin` (`'bounce'|'complaint'|'manual'|null`, key `origin`) Origin of the suppression.
- `$sourceId` (`string|null`, key `source_id`) Identifier of the event that caused the suppression, such as the email that bounced or complained.
- `$createdAt` (`string|null`, key `created_at`) Timestamp indicating when the suppression was created.
- `$object` (`string|null`, key `object`) Type of the response object.

## `Inbox`

- `$id` (`string`, key `id`) The ID of the inbox.
- `$name` (`string|null`, key `name`) Internal name for the inbox. Recipients do not see it.
- `$emailAddress` (`string`, key `email_address`) The address of the inbox.
- `$fromName` (`string|null`, key `from_name`) The name recipients see when mail is sent from this inbox. `null` when not set.
- `$unread` (`int`, key `unread`) The number of unread threads in the Inbox folder.
- `$lastReceived` (`string|null`, key `last_received`) ISO 8601 timestamp of the newest received email in the Inbox folder. `null` when the folder has no received email.
- `$createdAt` (`string`, key `created_at`) ISO 8601 timestamp when the inbox was created.
- `$updatedAt` (`string`, key `updated_at`) ISO 8601 timestamp when the inbox was last updated.
- `$object` (`string|null`, key `object`) The object type. Always `inbox`.
- `$domainId` (`string|null`, key `domain_id`) The ID of the domain that owns the address.
- `$receivingAddress` (`string|null`, key `receiving_address`) The address to forward mail to when forwarding is enabled. `null` otherwise.
- `$drafts` (`int|null`, key `drafts`) The number of unsent drafts.

## `InboxLabel`

- `$id` (`string`, key `id`) The ID of the label.
- `$name` (`string`, key `name`) The name of the label.
- `$color` (`string`, key `color`) The color of the label, as a `#RRGGBB` hex color in uppercase.
- `$createdAt` (`string`, key `created_at`) Timestamp when the label was created.

## `InboxThread`

- `$id` (`string`, key `id`) The ID of the thread.
- `$subject` (`string|null`, key `subject`) The subject of the thread.
- `$labels` (`list<InboxThreadLabel>`, key `labels`) The labels attached to the thread.
- `$read` (`bool`, key `read`) True only when every email in the thread is read.
- `$folder` (`'inbox'|'archive'|'spam'|'sent'|'trash'`, key `folder`) The folder the thread is in. Every thread is in exactly one folder. `inbox` holds threads with at least one received email. `archive` and `spam` hold threads moved there. `trash` holds threads scheduled for deletion in 30 days. `sent` holds threads whose emails are all outbound, and is assigned automatically.
- `$from` (`string|null`, key `from`) The sender email address. Can include the display name.
- `$to` (`list<string>|null`, key `to`) The recipients of the most recent email. For a received email, these are the addresses it was delivered to, not the full `To` header.
- `$cc` (`list<string>|null`, key `cc`) The CC recipients of the most recent email.
- `$bcc` (`list<string>|null`, key `bcc`) The BCC recipients of the most recent email. Always empty for a received email.
- `$emailCount` (`int|null`, key `email_count`) The number of emails in the thread.
- `$hasAttachment` (`bool|null`, key `has_attachment`) Whether the most recent email in the thread has an attachment.
- `$hasDraft` (`bool|null`, key `has_draft`) Whether the thread has an unsent draft.
- `$receivedAt` (`string|null`, key `received_at`) Timestamp when the thread was last active.
- `$object` (`string|null`, key `object`) The object type.

## `InboxThreadLabel`

- `$id` (`string`, key `id`) The ID of the label.
- `$name` (`string`, key `name`) The name of the label.
- `$color` (`string`, key `color`) The color of the label, as a `#RRGGBB` hex color in uppercase.

## `InboxThreadEmail`

- `$id` (`string`, key `id`) The ID of the message.
- `$direction` (`'inbound'|'outbound'`, key `direction`) Whether the inbox received the message (`inbound`) or sent it (`outbound`). A message the inbox sent to itself is `inbound`, so a reply to it goes to its sender.
- `$from` (`string`, key `from`) Sender email address. Includes the display name when the sender has one, in the format "Name <sender@domain.com>".
- `$to` (`list<string>`, key `to`) The recipients of the message. For a received message, these are the addresses it was delivered to, not the full `To` header.
- `$cc` (`list<string>`, key `cc`) The CC recipients of the message.
- `$bcc` (`list<string>`, key `bcc`) The BCC recipients of the message. Always empty for a received message.
- `$replyTo` (`list<string>`, key `reply_to`) The Reply-To addresses of the message.
- `$subject` (`string|null`, key `subject`) The subject of the message.
- `$messageId` (`string|null`, key `message_id`) The Message-ID header of the message.
- `$html` (`string|null`, key `html`) The HTML body.
- `$text` (`string|null`, key `text`) The plain-text body.
- `$attachments` (`list<array{id: string, filename: string, size: int}>`, key `attachments`) The attachments of the message.
- `$read` (`bool`, key `read`) Whether the message has been read.
- `$receivedAt` (`string`, key `received_at`) Timestamp when the inbox received the message, or when the inbox sent it.

## `InboxDraft`

- `$id` (`string`, key `id`) The ID of the draft.
- `$type` (`'standalone'|'reply'`, key `type`) `reply` when the draft replies to an email in an existing thread. `standalone` when the draft starts a new thread.
- `$to` (`list<string>|null`, key `to`) The recipients. `null` or empty when no recipients are set.
- `$cc` (`list<string>`, key `cc`) The CC recipients.
- `$bcc` (`list<string>`, key `bcc`) The BCC recipients.
- `$subject` (`string|null`, key `subject`) The subject.
- `$threadId` (`string|null`, key `thread_id`) The Thread ID when the draft is a reply. `null` otherwise.
- `$replyToEmailId` (`string|null`, key `reply_to_email_id`) The Email ID the draft replies to. `null` otherwise.
- `$updatedAt` (`string`, key `updated_at`) Timestamp when the draft was last saved.
- `$attachments` (`list<array{id: string, filename: string, content_type: string, size: int}>`, key `attachments`) The files stored on the draft.
- `$snippet` (`string|null`, key `snippet`) A short preview of the body.
- `$object` (`string|null`, key `object`) The object type.
- `$html` (`string|null`, key `html`) The HTML body.
- `$text` (`string|null`, key `text`) The plain text body. A reply draft created without a body has an empty string.
- `$emailId` (`string|null`, key `email_id`) The ID of the outbound email queued when the draft was sent. `null` until the draft is sent.
- `$createdAt` (`string|null`, key `created_at`) Timestamp when the draft was created.
