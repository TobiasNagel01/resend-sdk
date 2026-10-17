<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Emails\CancelEmailRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\GetEmailAttachmentRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\GetEmailMetricsRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\GetEmailRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\GetReceivedEmailAttachmentRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\GetReceivedEmailRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\ListEmailAttachmentsRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\ListEmailsRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\ListReceivedEmailAttachmentsRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\ListReceivedEmailsRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\SendBatchEmailsRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\SendEmailRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\ShareEmailRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\UpdateEmailRequest;

/**
 * Emails endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Emails extends BaseResource
{
    /**
     * Send an email
     *
     * @param  string  $from  Sender email address. To include a friendly name, use the format "Your Name <sender@domain.com>".
     * @param  string|list<string>  $to  Recipient email address. For multiple addresses, send as an array of strings. Max 50.
     * @param  string  $subject  Email subject.
     * @param  string|list<string>|null  $bcc  Bcc recipient email address. For multiple addresses, send as an array of strings.
     * @param  string|list<string>|null  $cc  Cc recipient email address. For multiple addresses, send as an array of strings.
     * @param  string|list<string>|null  $replyTo  Reply-to email address. For multiple addresses, send as an array of strings.
     * @param  string|null  $html  The HTML version of the message.
     * @param  string|null  $text  The plain text version of the message.
     * @param  array{id: string, variables?: array<string, mixed>}|null  $template  Use a published template to send the email. If provided, do not include html or text.
     * @param  array<string, mixed>|null  $customHeaders  Custom headers to add to the email.
     * @param  string|null  $scheduledAt  Schedule email to be sent later. The date should be in ISO 8601 format.
     * @param  list<array{content?: string, filename?: string, path?: string, content_type?: string, content_id?: string}>|null  $attachments
     * @param  list<array{name?: string, value?: string}>|null  $tags
     * @param  string|null  $topicId  The topic ID to scope the email to. If the recipient is a contact and opted-in to the topic, the email is sent. If opted-out, the email is not sent. If the recipient is not a contact, the email is sent if the topic's default subscription is opt_in.
     * @param  string|null  $idempotencyKey  A unique identifier for the request to ensure emails are only sent once. Learn more: https://resend.com/docs/dashboard/emails/idempotency-keys
     */
    public function send(
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
    ): Response {
        return $this->connector->send(new SendEmailRequest(
            $from,
            $to,
            $subject,
            $bcc,
            $cc,
            $replyTo,
            $html,
            $text,
            $template,
            $customHeaders,
            $scheduledAt,
            $attachments,
            $tags,
            $topicId,
            $idempotencyKey,
        ));
    }

    /**
     * Retrieve a list of emails
     *
     * `$response->dto()` returns a ListResponse<Email>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListEmailsRequest($limit, $after, $before));
    }

    /**
     * Retrieve a single email
     *
     * `$response->dto()` returns an Email.
     *
     * @param  string  $emailId  The ID of the email.
     */
    public function get(string $emailId): Response
    {
        return $this->connector->send(new GetEmailRequest($emailId));
    }

    /**
     * Update a single email
     *
     * @param  string  $emailId  The ID of the email.
     * @param  string  $scheduledAt  Schedule email to be sent later. The date should be in ISO 8601 format (e.g: 2024-08-05T11:52:01.858Z) or natural language (e.g.: "in 1 min").
     */
    public function update(string $emailId, string $scheduledAt): Response
    {
        return $this->connector->send(new UpdateEmailRequest($emailId, $scheduledAt));
    }

    /**
     * Cancel the schedule of the e-mail.
     *
     * `$response->dto()` returns an Email.
     *
     * @param  string  $emailId  The ID of the email.
     */
    public function cancel(string $emailId): Response
    {
        return $this->connector->send(new CancelEmailRequest($emailId));
    }

    /**
     * Create a shareable link for a sent or received email.
     *
     * @param  string  $emailId  The ID of the email.
     * @param  string|null  $expiresIn  How long the link stays valid for, as a duration like `10m`, `2 hours`, or `1 day`. Defaults to `48h` and cannot exceed 48 hours.
     */
    public function share(string $emailId, ?string $expiresIn = null): Response
    {
        return $this->connector->send(new ShareEmailRequest($emailId, $expiresIn));
    }

    /**
     * Trigger up to 100 batch emails at once.
     *
     * @param  list<array{from: string, to: string|list<string>, subject: string, bcc?: string|list<string>, cc?: string|list<string>, reply_to?: string|list<string>, html?: string, text?: string, template?: array{id: string, variables?: array<string, mixed>}, headers?: array<string, mixed>, scheduled_at?: string, attachments?: list<array{content?: string, filename?: string, path?: string, content_type?: string, content_id?: string}>, tags?: list<array{name?: string, value?: string}>, topic_id?: string}>  $emails  The items to send.
     * @param  string|null  $idempotencyKey  A unique identifier for the request to ensure emails are only sent once. Learn more: https://resend.com/docs/dashboard/emails/idempotency-keys
     */
    public function sendBatch(array $emails, ?string $idempotencyKey = null): Response
    {
        return $this->connector->send(new SendBatchEmailsRequest($emails, $idempotencyKey));
    }

    /**
     * Retrieve a list of attachments for a sent email
     *
     * `$response->dto()` returns a ListResponse<Attachment>.
     *
     * @param  string  $emailId  The ID of the email.
     * @param  int|null  $limit  Maximum number of attachments to return.
     * @param  string|null  $after  Pagination cursor to fetch results after this attachment ID. Cannot be used with 'before'.
     * @param  string|null  $before  Pagination cursor to fetch results before this attachment ID. Cannot be used with 'after'.
     */
    public function listAttachments(
        string $emailId,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListEmailAttachmentsRequest(
            $emailId,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Retrieve a single attachment for a sent email
     *
     * `$response->dto()` returns an Attachment.
     *
     * @param  string  $emailId  The ID of the email.
     * @param  string  $attachmentId  The ID of the attachment.
     */
    public function getAttachment(string $emailId, string $attachmentId): Response
    {
        return $this->connector->send(new GetEmailAttachmentRequest($emailId, $attachmentId));
    }

    /**
     * Retrieve a list of received emails
     *
     * `$response->dto()` returns a ListResponse<ReceivedEmail>.
     *
     * @param  int|null  $limit  Maximum number of received emails to return.
     * @param  string|null  $after  Pagination cursor to fetch results after this email ID. Cannot be used with 'before'.
     * @param  string|null  $before  Pagination cursor to fetch results before this email ID. Cannot be used with 'after'.
     */
    public function listReceiving(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListReceivedEmailsRequest($limit, $after, $before));
    }

    /**
     * Retrieve a single received email
     *
     * `$response->dto()` returns a ReceivedEmail.
     *
     * @param  string  $emailId  The ID of the received email.
     */
    public function getReceiving(string $emailId): Response
    {
        return $this->connector->send(new GetReceivedEmailRequest($emailId));
    }

    /**
     * Retrieve a list of attachments for a received email
     *
     * `$response->dto()` returns a ListResponse<Attachment>.
     *
     * @param  string  $emailId  The ID of the received email.
     * @param  int|null  $limit  Maximum number of attachments to return.
     * @param  string|null  $after  Pagination cursor to fetch results after this attachment ID. Cannot be used with 'before'.
     * @param  string|null  $before  Pagination cursor to fetch results before this attachment ID. Cannot be used with 'after'.
     */
    public function listReceivingAttachments(
        string $emailId,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListReceivedEmailAttachmentsRequest(
            $emailId,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Retrieve a single attachment for a received email
     *
     * `$response->dto()` returns an Attachment.
     *
     * @param  string  $emailId  The ID of the received email.
     * @param  string  $attachmentId  The ID of the attachment.
     */
    public function getReceivingAttachment(string $emailId, string $attachmentId): Response
    {
        return $this->connector->send(new GetReceivedEmailAttachmentRequest($emailId, $attachmentId));
    }

    /**
     * Retrieve account-level email metrics
     *
     * @param  string|null  $startDate  The start of the date range, as an ISO 8601 date or datetime. Must be on or before `end_date`. Defaults to 6 days before `end_date`.
     * @param  string|null  $endDate  The end of the date range, as an ISO 8601 date or datetime. Values in the future are clamped to the current time. Defaults to now.
     * @param  string|null  $timezone  The IANA timezone (e.g. `America/New_York`) used to bucket periods when `period` is in `dimensions`.
     * @param  'hourly'|'daily'|'weekly'|'monthly'|null  $granularity  The bucket size used when `period` is in `dimensions`. The date range can't produce more than 10,000 periods at the chosen granularity.
     * @param  list<'received'|'delivered'|'complained'|'suppressed'|'bounced'|'bounced_transient'|'bounced_permanent'|'bounced_undetermined'|'opened'|'clicked'|'unsubscribed'|'delivery_delayed'|'failed'|'sent'|'unique_opened'|'unique_clicked'|'delivery_rate'|'open_rate'|'click_rate'|'bounce_rate'|'complaint_rate'|'unsubscribe_rate'>|null  $metrics  List of metrics to include in the response. Defaults to all metrics. Accepts a comma-separated value, the parameter repeated, or a mix of both.
     * @param  list<'period'|'domain'|'email'|'broadcast'>|null  $dimensions  List of dimensions to break the response down by. `email` cannot be combined with `broadcast`. Defaults to `[]`, returning a single `totals` row for the whole range, with no `data`. Accepts a comma-separated value, the parameter repeated, or a mix of both.
     * @param  list<string>|null  $domainId  List of sending domain IDs to restrict the response to, up to 100. Accepts a comma-separated value, the parameter repeated, or a mix of both.
     * @param  list<string>|null  $emailId  List of email IDs to restrict the response to, up to 100. Cannot be combined with the `broadcast` dimension or `broadcast_id`. Accepts a comma-separated value, the parameter repeated, or a mix of both.
     * @param  list<string>|null  $broadcastId  List of broadcast IDs to restrict the response to, up to 100. Cannot be combined with the `email` dimension or `email_id`. Accepts a comma-separated value, the parameter repeated, or a mix of both.
     */
    public function metrics(
        ?string $startDate = null,
        ?string $endDate = null,
        ?string $timezone = null,
        ?string $granularity = null,
        ?array $metrics = null,
        ?array $dimensions = null,
        ?array $domainId = null,
        ?array $emailId = null,
        ?array $broadcastId = null,
    ): Response {
        return $this->connector->send(new GetEmailMetricsRequest(
            $startDate,
            $endDate,
            $timezone,
            $granularity,
            $metrics,
            $dimensions,
            $domainId,
            $emailId,
            $broadcastId,
        ));
    }
}
