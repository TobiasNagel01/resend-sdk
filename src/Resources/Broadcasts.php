<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Broadcasts\CancelBroadcastRequest;
use TobiasNagel01\ResendSdk\Requests\Broadcasts\CreateBroadcastRequest;
use TobiasNagel01\ResendSdk\Requests\Broadcasts\DuplicateBroadcastRequest;
use TobiasNagel01\ResendSdk\Requests\Broadcasts\GetBroadcastRequest;
use TobiasNagel01\ResendSdk\Requests\Broadcasts\ListBroadcastClickedLinksRequest;
use TobiasNagel01\ResendSdk\Requests\Broadcasts\ListBroadcastRecipientsRequest;
use TobiasNagel01\ResendSdk\Requests\Broadcasts\ListBroadcastsRequest;
use TobiasNagel01\ResendSdk\Requests\Broadcasts\RemoveBroadcastRequest;
use TobiasNagel01\ResendSdk\Requests\Broadcasts\SendBroadcastRequest;
use TobiasNagel01\ResendSdk\Requests\Broadcasts\UpdateBroadcastRequest;

/**
 * Broadcasts endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Broadcasts extends BaseResource
{
    /**
     * Create a broadcast
     *
     * @param  string  $segmentId  Unique identifier of the segment this broadcast will be sent to.
     * @param  string  $from  The email address of the sender.
     * @param  string  $subject  The subject line of the email.
     * @param  string|null  $name  Name of the broadcast.
     * @param  string|null  $audienceId  Use `segment_id` instead. Unique identifier of the segment this broadcast will be sent to.
     * @param  list<string>|null  $replyTo  The email addresses to which replies should be sent.
     * @param  string|null  $previewText  The preview text of the email.
     * @param  string|null  $html  The HTML version of the message.
     * @param  string|null  $text  The plain text version of the message.
     * @param  string|null  $topicId  The topic ID that the broadcast will be scoped to.
     * @param  bool|null  $send  Whether to send the broadcast immediately or keep it as a draft.
     * @param  string|null  $scheduledAt  Schedule time to send the broadcast. Can only be used if `send` is true.
     */
    public function create(
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
    ): Response {
        return $this->connector->send(new CreateBroadcastRequest(
            $segmentId,
            $from,
            $subject,
            $name,
            $audienceId,
            $replyTo,
            $previewText,
            $html,
            $text,
            $topicId,
            $send,
            $scheduledAt,
        ));
    }

    /**
     * Retrieve a list of broadcasts
     *
     * `$response->dto()` returns a ListResponse<Broadcast>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListBroadcastsRequest($limit, $after, $before));
    }

    /**
     * Remove an existing broadcast that is in the draft status
     *
     * @param  string  $id  The Broadcast ID.
     */
    public function remove(string $id): Response
    {
        return $this->connector->send(new RemoveBroadcastRequest($id));
    }

    /**
     * Retrieve a single broadcast
     *
     * `$response->dto()` returns a Broadcast.
     *
     * @param  string  $id  The Broadcast ID.
     */
    public function get(string $id): Response
    {
        return $this->connector->send(new GetBroadcastRequest($id));
    }

    /**
     * Update an existing broadcast
     *
     * @param  string  $id  The Broadcast ID.
     * @param  string|null  $name  Name of the broadcast.
     * @param  string|null  $audienceId  Use `segment_id` instead. Unique identifier of the audience this broadcast will be sent to.
     * @param  string|null  $segmentId  Unique identifier of the segment this broadcast will be sent to.
     * @param  string|null  $from  The email address of the sender.
     * @param  string|null  $subject  The subject line of the email.
     * @param  list<string>|null  $replyTo  The email addresses to which replies should be sent.
     * @param  string|null  $previewText  The preview text of the email.
     * @param  string|null  $html  The HTML version of the message.
     * @param  string|null  $text  The plain text version of the message.
     * @param  string|null  $topicId  The topic ID that the broadcast will be scoped to.
     */
    public function update(
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
    ): Response {
        return $this->connector->send(new UpdateBroadcastRequest(
            $id,
            $name,
            $audienceId,
            $segmentId,
            $from,
            $subject,
            $replyTo,
            $previewText,
            $html,
            $text,
            $topicId,
        ));
    }

    /**
     * Send or schedule a broadcast
     *
     * @param  string  $id  The Broadcast ID.
     * @param  string|null  $scheduledAt  Schedule email to be sent later. The date should be in ISO 8601 format.
     */
    public function send(string $id, ?string $scheduledAt = null): Response
    {
        return $this->connector->send(new SendBroadcastRequest($id, $scheduledAt));
    }

    /**
     * Cancel a broadcast
     *
     * @param  string  $id  The Broadcast ID.
     */
    public function cancel(string $id): Response
    {
        return $this->connector->send(new CancelBroadcastRequest($id));
    }

    /**
     * Duplicate a broadcast
     *
     * @param  string  $id  The Broadcast ID.
     */
    public function duplicate(string $id): Response
    {
        return $this->connector->send(new DuplicateBroadcastRequest($id));
    }

    /**
     * Retrieve broadcast recipients
     *
     * @param  string  $id  The Broadcast ID.
     * @param  'sent'|'delivered'|'opened'|'clicked'|'bounced'|'complained'|'unsubscribed'|'suppressed'  $type  The recipient event type to filter by.
     * @param  string|null  $email  Filter recipients whose email address contains this value.
     * @param  'permanent'|'transient'|'undetermined'|null  $bounceType  Filter bounced recipients by bounce type. Only valid when `type` is `bounced`.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function listRecipients(
        string $id,
        string $type,
        ?string $email = null,
        ?string $bounceType = null,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListBroadcastRecipientsRequest(
            $id,
            $type,
            $email,
            $bounceType,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Retrieve a broadcast's clicked links
     *
     * @param  string  $id  The Broadcast ID.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function listClickedLinks(
        string $id,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListBroadcastClickedLinksRequest(
            $id,
            $limit,
            $after,
            $before,
        ));
    }
}
