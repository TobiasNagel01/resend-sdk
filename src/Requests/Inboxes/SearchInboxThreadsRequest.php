<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Search the threads of an inbox
 *
 * Finds threads by the text of their emails, who sent or received them, whether they have attachments, and their dates. Results are ordered by latest activity, newest first, and paginate like the list threads endpoint, so a cursor that is not a thread ID returns a 422. Search can be up to about a minute behind new emails. Different parameters combine, so a thread must match all of them. `folders`, `labels`, and `read` apply to the thread. `query`, `from`, `to`, `cc`, `bcc`, `has_attachment`, `start_date`, and `end_date` must all match the same email in the thread. When any of these email filters is set, the matching email must itself be in one of `folders`. For `sent`, that means an email the inbox sent. When more than 10,000 threads match, search covers the 10,000 with the newest matching email.
 *
 * GET /inboxes/{inbox_id}/threads/search
 *
 * @generated from the Resend OpenAPI spec (inboxes/search-threads). Do not edit by hand, run `composer generate` instead.
 */
class SearchInboxThreadsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
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
    public function __construct(
        public readonly string $inboxId,
        public readonly ?string $searchQuery = null,
        public readonly ?array $from = null,
        public readonly ?array $to = null,
        public readonly ?array $cc = null,
        public readonly ?array $bcc = null,
        public readonly ?bool $hasAttachment = null,
        public readonly ?string $startDate = null,
        public readonly ?string $endDate = null,
        public readonly ?array $folders = null,
        public readonly ?array $labels = null,
        public readonly ?bool $read = null,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/threads/search';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'query' => $this->searchQuery,
            'from' => $this->from,
            'to' => $this->to,
            'cc' => $this->cc,
            'bcc' => $this->bcc,
            'has_attachment' => $this->hasAttachment,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'folders' => $this->folders,
            'labels' => $this->labels,
            'read' => $this->read,
            'limit' => $this->limit,
            'after' => $this->after,
            'before' => $this->before,
        ]);
    }
}
