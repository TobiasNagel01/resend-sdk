<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Inboxes\AddInboxThreadLabelsRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\CreateInboxDraftRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\CreateInboxLabelRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\CreateInboxRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\ForwardInboxThreadEmailRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\GetInboxAgentRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\GetInboxDraftRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\GetInboxRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\GetInboxThreadEmailRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\GetInboxThreadRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\ListInboxDraftsRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\ListInboxesRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\ListInboxLabelsRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\ListInboxThreadEmailsRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\ListInboxThreadsRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\RemoveInboxDraftRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\RemoveInboxLabelRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\RemoveInboxRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\RemoveInboxThreadLabelRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\RemoveInboxThreadRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\ReplyInboxThreadEmailRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\SearchInboxThreadsRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\SendInboxDraftRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\SetInboxThreadLabelsRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\UpdateInboxAgentRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\UpdateInboxDraftRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\UpdateInboxLabelRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\UpdateInboxRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\UpdateInboxThreadRequest;
use TobiasNagel01\ResendSdk\Support\Omit;

/**
 * Inboxes endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Inboxes extends BaseResource
{
    /**
     * Create an inbox
     *
     * @param  string  $emailAddress  The inbox email address on one of your domains. The API trims and lowercases it. The part before the `@` is at most 64 characters and contains only letters, numbers, and `. _ % -`. A `+` returns a 422. It cannot start or end with a dot or contain two dots in a row.
     * @param  string|null  $name  Internal name for the inbox. Recipients do not see it. Max 64 characters. Defaults to `email_address`.
     * @param  string|null  $fromName  The name recipients see when mail is sent from this inbox. A plain name, not a `Name <email>` address. Max 78 characters. It cannot contain a colon, `<`, `>`, line breaks, or other control characters. An email address inside the name must be on a domain the team has verified for sending. An empty string leaves it unset.
     * @param  bool|null  $forwarding  When `true`, Resend provisions a receiving address so you can receive mail without adding an MX record. The address is returned in `receiving_address`.
     */
    public function create(
        string $emailAddress,
        ?string $name = null,
        ?string $fromName = null,
        ?bool $forwarding = null,
    ): Response {
        return $this->connector->send(new CreateInboxRequest(
            $emailAddress,
            $name,
            $fromName,
            $forwarding,
        ));
    }

    /**
     * Retrieve a list of inboxes
     *
     * `$response->dto()` returns a ListResponse<Inbox>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListInboxesRequest($limit, $after, $before));
    }

    /**
     * Retrieve a single inbox by ID or email address
     *
     * `$response->dto()` returns an Inbox.
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     */
    public function get(string $inboxId): Response
    {
        return $this->connector->send(new GetInboxRequest($inboxId));
    }

    /**
     * Update an existing inbox by ID or email address
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string|null  $name  New internal name for the inbox. Recipients do not see it. Between 1 and 64 characters after trimming.
     * @param  string|null  $fromName  The name recipients see when mail is sent from this inbox. A plain name, not a `Name <email>` address. Max 78 characters. It cannot contain a colon, `<`, `>`, line breaks, or other control characters. An email address inside the name must be on a domain the team has verified for sending. An empty string removes it.
     */
    public function update(string $inboxId, ?string $name = null, ?string $fromName = null): Response
    {
        return $this->connector->send(new UpdateInboxRequest($inboxId, $name, $fromName));
    }

    /**
     * Remove an existing inbox by ID or email address
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     */
    public function remove(string $inboxId): Response
    {
        return $this->connector->send(new RemoveInboxRequest($inboxId));
    }

    /**
     * Retrieve the agent settings for an inbox
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     */
    public function getAgent(string $inboxId): Response
    {
        return $this->connector->send(new GetInboxAgentRequest($inboxId));
    }

    /**
     * Update the agent settings for an inbox
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string|null|Omit  $instructions  Instructions the agent follows when it handles the threads of the inbox. Max 4000 characters. Leading and trailing whitespace is trimmed, and the trimmed value must not be empty. Send null to clear the instructions.
     * @param  'concise_professional'|'concise_casual'|'expanded_professional'|'expanded_casual'|null|Omit  $tone  The tone the agent writes in. Send null to clear the tone.
     * @param  list<'draft_reply'|'forward_thread'|'add_labels'|'assign_thread'|'mark_as_spam'|'archive'|'move_to_trash'>|null  $actions  The actions the agent can take. Replaces the whole set. Duplicates are removed. Send an empty array to disable all actions. The old names `archive_thread` and `delete_thread` return a 422. Use `archive` and `move_to_trash`.
     */
    public function updateAgent(
        string $inboxId,
        string|Omit|null $instructions = Omit::Value,
        string|Omit|null $tone = Omit::Value,
        ?array $actions = null,
    ): Response {
        return $this->connector->send(new UpdateInboxAgentRequest(
            $inboxId,
            $instructions,
            $tone,
            $actions,
        ));
    }

    /**
     * Retrieve a list of inbox labels
     *
     * `$response->dto()` returns a ListResponse<InboxLabel>.
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     */
    public function listLabels(string $inboxId): Response
    {
        return $this->connector->send(new ListInboxLabelsRequest($inboxId));
    }

    /**
     * Create a label on an inbox
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $name  The name of the label. Max 64 characters. Leading and trailing whitespace is trimmed. Must not match another label on the inbox, compared without case.
     * @param  string|null  $color  The color of the label, as a `#RRGGBB` hex color. It is stored in uppercase. When omitted, a random color from the dashboard palette is used.
     */
    public function createLabel(string $inboxId, string $name, ?string $color = null): Response
    {
        return $this->connector->send(new CreateInboxLabelRequest($inboxId, $name, $color));
    }

    /**
     * Update an existing inbox label
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $labelId  The Label ID.
     * @param  string|null  $name  A new name for the label. Max 64 characters. Leading and trailing whitespace is trimmed. Must not match another label on the inbox, compared without case.
     * @param  string|null  $color  A new color for the label, as a `#RRGGBB` hex color. It is stored in uppercase.
     */
    public function updateLabel(
        string $inboxId,
        string $labelId,
        ?string $name = null,
        ?string $color = null,
    ): Response {
        return $this->connector->send(new UpdateInboxLabelRequest(
            $inboxId,
            $labelId,
            $name,
            $color,
        ));
    }

    /**
     * Remove an existing inbox label
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $labelId  The Label ID.
     */
    public function removeLabel(string $inboxId, string $labelId): Response
    {
        return $this->connector->send(new RemoveInboxLabelRequest($inboxId, $labelId));
    }

    /**
     * Retrieve a list of inbox threads
     *
     * `$response->dto()` returns a ListResponse<InboxThread>.
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  list<'inbox'|'archive'|'spam'|'sent'|'trash'>|null  $folders  Comma-separated folders to list, for example `inbox,sent`. Repeating the parameter returns a 422 validation_error. A thread is returned when any of its emails is in one of the folders, so a thread in `inbox` with an email you sent matches both `inbox` and `sent`. Defaults to `inbox`, or to `inbox,archive,sent` when `labels` is set. `spam` and `trash` are only included when you name them.
     * @param  list<string>|null  $labels  Comma-separated label IDs. Returns threads with any of these labels. Up to 50 IDs. An ID that does not exist in the inbox returns a 404. Repeating the parameter returns a 422 validation_error.
     * @param  bool|null  $read  `true` returns threads where every email is read. `false` returns threads with at least one unread email. Only the literal values `true` and `false` are accepted.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function listThreads(
        string $inboxId,
        ?array $folders = null,
        ?array $labels = null,
        ?bool $read = null,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListInboxThreadsRequest(
            $inboxId,
            $folders,
            $labels,
            $read,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Search the threads of an inbox
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string|null  $searchQuery  Free text to search for in the subject, body, sender, recipients, and attachment names. Every word must match. Wrap words in double quotes to match an exact phrase. Start a word or quoted phrase with `-` to exclude it. Max 256 characters and 32 words.
     * @param  list<string>|null  $from  Comma-separated senders. Each value matches part of the sender's address or name, without case. Returns threads that match any of them. Up to 20 values. Repeating the parameter returns a 422 validation_error.
     * @param  list<string>|null  $to  Comma-separated recipients, matched the same way as `from`. Up to 20 values. Repeating the parameter returns a 422 validation_error.
     * @param  list<string>|null  $cc  Comma-separated CC recipients, matched the same way as `from`. Up to 20 values. Repeating the parameter returns a 422 validation_error.
     * @param  list<string>|null  $bcc  Comma-separated BCC recipients, matched the same way as `from`. Up to 20 values. Repeating the parameter returns a 422 validation_error.
     * @param  bool|null  $hasAttachment  `true` matches emails with an attachment. `false` matches emails without one. Only the literal values `true` and `false` are accepted.
     * @param  string|null  $startDate  Matches emails sent on or after this date. Accepts a date like `2026-09-01` or an ISO 8601 timestamp, in UTC unless the timestamp has an offset. An empty value returns a 422.
     * @param  string|null  $endDate  Matches emails sent on or before this date. Same formats as `start_date`. A date covers that whole day, so `start_date=2026-09-01&end_date=2026-09-30` covers all of September. A timestamp is used as given. An `end_date` before `start_date` returns a 422 validation_error. An empty value returns a 422.
     * @param  list<'inbox'|'archive'|'spam'|'sent'|'trash'>|null  $folders  Comma-separated folders to search, for example `inbox,sent`. Repeating the parameter returns a 422 validation_error. A thread is returned when any of its emails is in one of the folders. Defaults to `inbox`, or to `inbox,archive,sent` when `labels` is set. `spam` and `trash` are only included when you name them.
     * @param  list<string>|null  $labels  Comma-separated label IDs. Returns threads with any of these labels. Up to 50 IDs. An ID that does not exist in the inbox returns a 404. Repeating the parameter returns a 422 validation_error.
     * @param  bool|null  $read  `true` returns threads where every email is read. `false` returns threads with at least one unread email. Only the literal values `true` and `false` are accepted.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function searchThreads(
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
    ): Response {
        return $this->connector->send(new SearchInboxThreadsRequest(
            $inboxId,
            $searchQuery,
            $from,
            $to,
            $cc,
            $bcc,
            $hasAttachment,
            $startDate,
            $endDate,
            $folders,
            $labels,
            $read,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Retrieve a single inbox thread
     *
     * `$response->dto()` returns an InboxThread.
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     */
    public function getThread(string $inboxId, string $threadId): Response
    {
        return $this->connector->send(new GetInboxThreadRequest($inboxId, $threadId));
    }

    /**
     * Update an existing inbox thread
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  bool|null  $read  Marks every email in the thread read or unread.
     * @param  'inbox'|'archive'|'spam'|'trash'|null  $folder  Moves the thread to this folder. `sent` is assigned automatically and cannot be set.
     */
    public function updateThread(
        string $inboxId,
        string $threadId,
        ?bool $read = null,
        ?string $folder = null,
    ): Response {
        return $this->connector->send(new UpdateInboxThreadRequest(
            $inboxId,
            $threadId,
            $read,
            $folder,
        ));
    }

    /**
     * Remove an existing inbox thread
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     */
    public function removeThread(string $inboxId, string $threadId): Response
    {
        return $this->connector->send(new RemoveInboxThreadRequest($inboxId, $threadId));
    }

    /**
     * Add labels to an inbox thread
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  list<string>  $labels  The IDs of the labels to apply to the thread. Between 1 and 10 IDs, each a label of the inbox.
     */
    public function addThreadLabels(string $inboxId, string $threadId, array $labels): Response
    {
        return $this->connector->send(new AddInboxThreadLabelsRequest($inboxId, $threadId, $labels));
    }

    /**
     * Set the labels of an inbox thread
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  list<string>  $labels  The IDs of the labels the thread carries after the change. Up to 100 IDs, each a label of the inbox. Pass an empty array to take every label off the thread.
     */
    public function setThreadLabels(string $inboxId, string $threadId, array $labels): Response
    {
        return $this->connector->send(new SetInboxThreadLabelsRequest($inboxId, $threadId, $labels));
    }

    /**
     * Remove a label from an inbox thread
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  string  $labelId  The Label ID.
     */
    public function removeThreadLabel(string $inboxId, string $threadId, string $labelId): Response
    {
        return $this->connector->send(new RemoveInboxThreadLabelRequest($inboxId, $threadId, $labelId));
    }

    /**
     * Retrieve a list of thread emails
     *
     * `$response->dto()` returns a ListResponse<InboxThreadEmail>.
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function listThreadEmails(
        string $inboxId,
        string $threadId,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListInboxThreadEmailsRequest(
            $inboxId,
            $threadId,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Retrieve a single thread email
     *
     * `$response->dto()` returns an InboxThreadEmail.
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  string  $emailId  The Email ID, as returned in `data[].id` by the list thread emails endpoint.
     */
    public function getThreadEmail(string $inboxId, string $threadId, string $emailId): Response
    {
        return $this->connector->send(new GetInboxThreadEmailRequest($inboxId, $threadId, $emailId));
    }

    /**
     * Reply to a thread email
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  string  $emailId  The Email ID of the message to reply to, as returned in `data[].id` by the list thread emails endpoint.
     * @param  string|list<string>|null|Omit  $cc  CC recipient email address. For multiple addresses, send as an array of strings. Without `reply_all`, the reply copies only these addresses. With `reply_all`, these addresses are merged with the copied recipients, without duplicates. `cc` and `bcc` combined must be fewer than 50 addresses. After the `to` recipients are added, the reply cannot exceed 50 recipients. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $bcc  BCC recipient email address. For multiple addresses, send as an array of strings. BCC recipients of the original message are never copied. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|null  $html  The HTML body of the reply.
     * @param  string|null  $text  The plain-text body of the reply.
     * @param  string|null  $subject  The subject of the reply. Cannot be only whitespace or contain a line break. When omitted, the thread subject is used, prefixed with `Re:` if it does not already start with it.
     * @param  bool|null  $replyAll  Reply to everyone on the original message. For a message the inbox received, the reply goes to its `Reply-To` addresses, or to its sender when it has none, and copies the other addresses of its `To` header and its `cc` recipients in `cc`. For a message the inbox sent, the reply goes to that message's `Reply-To` addresses when they are not the inbox address, otherwise to its `to` recipients, and copies its `cc` recipients. The inbox address is always excluded, and duplicates are removed.
     * @param  list<array{content?: string, filename?: string, path?: string, content_type?: string, content_id?: string}>|null|Omit  $attachments  Files to attach, as on `POST /emails`. Each one needs `content` or `path`. The `content` of all files can total at most 25 MB. A `path` file does not count toward the 25 MB, because it is fetched when the email is sent. An empty file, a blocked file type, a `path` that does not start with `http` or that starts with `http://localhost:`, or a `content_type` that is not a valid MIME type returns a 422. Other `path` problems fail the email when it is sent, not the request.
     * @param  array<string, mixed>|null|Omit  $customHeaders  Custom headers to add to the email. The `In-Reply-To`, `References` and `Reply-To` headers are set by Resend and cannot be set here. Sending one of them, in any letter case, returns a 422. Header names cannot be empty, and names and values cannot contain line breaks or null characters, or the request returns a 422. `null` means no custom headers.
     * @param  string|null  $idempotencyKey  A unique key for the request, so the reply is sent only once. A retry with the same key within 24 hours returns the first successful (2xx) response, with the `idempotent-replayed: true` header. A failed request is not stored, so it can be retried with the same key. Reusing the key with a different body, or while the first request is still running, returns a 409. An empty key, or one longer than 256 characters, returns a 400 `invalid_idempotency_key`. Learn more: https://resend.com/docs/dashboard/emails/idempotency-keys
     */
    public function replyThreadEmail(
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
    ): Response {
        return $this->connector->send(new ReplyInboxThreadEmailRequest(
            $inboxId,
            $threadId,
            $emailId,
            $cc,
            $bcc,
            $html,
            $text,
            $subject,
            $replyAll,
            $attachments,
            $customHeaders,
            $idempotencyKey,
        ));
    }

    /**
     * Forward a thread email
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $threadId  The Thread ID.
     * @param  string  $emailId  The Email ID of the message to forward, as returned in `data[].id` by the list thread emails endpoint.
     * @param  string|list<string>  $to  Recipient email address. For multiple addresses, send as an array of strings. Must name at least one address. `to`, `cc` and `bcc` combined cannot exceed 50 recipients. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $cc  CC recipient email address. For multiple addresses, send as an array of strings. Counts toward the 50-recipient limit. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $bcc  BCC recipient email address. For multiple addresses, send as an array of strings. Counts toward the 50-recipient limit. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|null  $html  An HTML note sent above the quoted original.
     * @param  string|null  $text  A plain-text note sent above the quoted original.
     * @param  string|null  $subject  The subject of the forward. Cannot be only whitespace or contain a line break. When omitted, the thread subject is used, prefixed with `Fwd:` if it does not already start with it.
     * @param  list<array{content?: string, filename?: string, path?: string, content_type?: string, content_id?: string}>|null|Omit  $attachments  Files to attach, as on `POST /emails`. Each one needs `content` or `path`. They share one limit with the attachments of the original message, which the forward also sends. Together they can have at most 25 MB of `content`. A `path` file does not count toward the 25 MB, because it is fetched when the email is sent. An empty file, a blocked file type, a `path` that does not start with `http` or that starts with `http://localhost:`, or a `content_type` that is not a valid MIME type returns a 422. Other `path` problems fail the email when it is sent, not the request.
     * @param  array<string, mixed>|null|Omit  $customHeaders  Custom headers to add to the email. The `In-Reply-To`, `References` and `Reply-To` headers are set by Resend and cannot be set here. Sending one of them, in any letter case, returns a 422. Header names cannot be empty, and names and values cannot contain line breaks or null characters, or the request returns a 422. `null` means no custom headers.
     * @param  string|null  $idempotencyKey  A unique key for the request, so the forward is sent only once. A retry with the same key within 24 hours returns the first successful (2xx) response, with the `idempotent-replayed: true` header. A failed request is not stored, so it can be retried with the same key. Reusing the key with a different body, or while the first request is still running, returns a 409. An empty key, or one longer than 256 characters, returns a 400 `invalid_idempotency_key`. Learn more: https://resend.com/docs/dashboard/emails/idempotency-keys
     */
    public function forwardThreadEmail(
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
    ): Response {
        return $this->connector->send(new ForwardInboxThreadEmailRequest(
            $inboxId,
            $threadId,
            $emailId,
            $to,
            $cc,
            $bcc,
            $html,
            $text,
            $subject,
            $attachments,
            $customHeaders,
            $idempotencyKey,
        ));
    }

    /**
     * Retrieve a list of drafts
     *
     * `$response->dto()` returns a ListResponse<InboxDraft>.
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function listDrafts(
        string $inboxId,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListInboxDraftsRequest(
            $inboxId,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Create a draft
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string|list<string>|null|Omit  $to  The recipients. For multiple addresses, send an array of strings. Each value can include a friendly name, for example `Ada Lovelace <ada@example.org>`. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $cc  The CC recipients. For multiple addresses, send an array of strings. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $bcc  The BCC recipients. For multiple addresses, send an array of strings. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|null|Omit  $subject  The subject. Max 2000 characters. A string that is only whitespace, or that contains a line break, is rejected.
     * @param  string|null|Omit  $html  The HTML body.
     * @param  string|null|Omit  $text  The plain text body.
     * @param  list<array{content: string, filename: string, content_type: string}>|null|Omit  $attachments  Files to store on the draft. Each one needs `content`, `filename` and `content_type`. A `path` without `content` returns a 422, and when both are sent, `path` is ignored. A `content_id` returns a 422. The files on a draft can total at most 25 MB. An empty file or a blocked file type returns a 422.
     * @param  string|null  $threadId  The Thread ID to reply in. Must be sent with `reply_to_email_id`.
     * @param  string|null  $replyToEmailId  The Email ID to reply to, as returned in `data[].id` by the list thread emails endpoint. Must be sent with `thread_id`.
     * @param  string|null  $idempotencyKey  A unique key for the request, so the draft is created only once. A retry with the same key within 24 hours returns the first successful (2xx) response, with the `idempotent-replayed: true` header. A failed request is not stored, so it can be retried with the same key. Reusing the key with a different body, or while the first request is still running, returns a 409. An empty key, or one longer than 256 characters, returns a 400 `invalid_idempotency_key`. Learn more: https://resend.com/docs/dashboard/emails/idempotency-keys
     */
    public function createDraft(
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
    ): Response {
        return $this->connector->send(new CreateInboxDraftRequest(
            $inboxId,
            $to,
            $cc,
            $bcc,
            $subject,
            $html,
            $text,
            $attachments,
            $threadId,
            $replyToEmailId,
            $idempotencyKey,
        ));
    }

    /**
     * Retrieve a single draft
     *
     * `$response->dto()` returns an InboxDraft.
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $draftId  The Draft ID.
     */
    public function getDraft(string $inboxId, string $draftId): Response
    {
        return $this->connector->send(new GetInboxDraftRequest($inboxId, $draftId));
    }

    /**
     * Update an existing draft
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $draftId  The Draft ID.
     * @param  string|list<string>|null|Omit  $to  The recipients. For multiple addresses, send an array of strings. Each value can include a friendly name. Pass `null` to clear. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $cc  The CC recipients. Pass `null` or `[]` to clear. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $bcc  The BCC recipients. Pass `null` or `[]` to clear. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|null|Omit  $subject  The subject. Max 2000 characters. Cannot be only whitespace or contain a line break. Pass `null` to clear.
     * @param  string|null|Omit  $html  The HTML body. Pass `null` to clear.
     * @param  string|null|Omit  $text  The plain text body. Pass `null` to clear.
     * @param  list<array{content: string, filename: string, content_type: string}>|null|Omit  $attachments  Files to store on the draft. Each one needs `content`, `filename` and `content_type`. A `path` without `content` returns a 422, and when both are sent, `path` is ignored. A `content_id` returns a 422. The files on a draft can total at most 25 MB. An empty file or a blocked file type returns a 422. Sending the field replaces every attachment on the draft. Send `[]` to remove them all. `null` also removes them all.
     */
    public function updateDraft(
        string $inboxId,
        string $draftId,
        string|array|Omit|null $to = Omit::Value,
        string|array|Omit|null $cc = Omit::Value,
        string|array|Omit|null $bcc = Omit::Value,
        string|Omit|null $subject = Omit::Value,
        string|Omit|null $html = Omit::Value,
        string|Omit|null $text = Omit::Value,
        array|Omit|null $attachments = Omit::Value,
    ): Response {
        return $this->connector->send(new UpdateInboxDraftRequest(
            $inboxId,
            $draftId,
            $to,
            $cc,
            $bcc,
            $subject,
            $html,
            $text,
            $attachments,
        ));
    }

    /**
     * Remove an existing draft
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $draftId  The Draft ID.
     */
    public function removeDraft(string $inboxId, string $draftId): Response
    {
        return $this->connector->send(new RemoveInboxDraftRequest($inboxId, $draftId));
    }

    /**
     * Send a draft
     *
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $draftId  The Draft ID.
     * @param  array<string, mixed>|null|Omit  $customHeaders  Custom headers to add to the email. The `In-Reply-To`, `References` and `Reply-To` headers are set by Resend and cannot be set here. Sending one of them, in any letter case, returns a 422. Header names cannot be empty, and names and values cannot contain line breaks or null characters, or the request returns a 422. `null` means no custom headers.
     * @param  string|null  $idempotencyKey  A unique key for the request, so the draft is sent only once. A retry with the same key within 24 hours returns the first successful (2xx) response, with the `idempotent-replayed: true` header. A failed request is not stored, so it can be retried with the same key. Reusing the key with a different body, or while the first request is still running, returns a 409. An empty key, or one longer than 256 characters, returns a 400 `invalid_idempotency_key`. Learn more: https://resend.com/docs/dashboard/emails/idempotency-keys
     */
    public function sendDraft(
        string $inboxId,
        string $draftId,
        array|Omit|null $customHeaders = Omit::Value,
        ?string $idempotencyKey = null,
    ): Response {
        return $this->connector->send(new SendInboxDraftRequest(
            $inboxId,
            $draftId,
            $customHeaders,
            $idempotencyKey,
        ));
    }
}
