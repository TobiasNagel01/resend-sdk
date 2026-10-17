<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (broadcasts/list, broadcasts/get). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Broadcast
{
    /**
     * @param  string|null  $id  Unique identifier for the broadcast.
     * @param  string|null  $name  Name of the broadcast.
     * @param  string|null  $audienceId  Deprecated. Use segment_id instead.
     * @param  string|null  $segmentId  Unique identifier of the segment this broadcast will be sent to.
     * @param  string|null  $status  The status of the broadcast.
     * @param  string|null  $createdAt  Timestamp indicating when the broadcast was created.
     * @param  string|null  $scheduledAt  Timestamp indicating when the broadcast is scheduled to be sent.
     * @param  string|null  $sentAt  Timestamp indicating when the broadcast was sent.
     * @param  string|null  $topicId  The topic ID that the broadcast is scoped to.
     * @param  string|null  $from  The email address of the sender.
     * @param  string|null  $subject  The subject line of the email.
     * @param  list<string>|null  $replyTo  The email addresses to which replies should be sent.
     * @param  string|null  $previewText  The preview text of the email.
     * @param  string|null  $text  The plain text version of the broadcast content.
     * @param  string|null  $html  The HTML version of the broadcast content.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $audienceId = null,
        public ?string $segmentId = null,
        public ?string $status = null,
        public ?string $createdAt = null,
        public ?string $scheduledAt = null,
        public ?string $sentAt = null,
        public ?string $topicId = null,
        public ?string $from = null,
        public ?string $subject = null,
        public ?array $replyTo = null,
        public ?string $previewText = null,
        public ?string $text = null,
        public ?string $html = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            audienceId: $data['audience_id'] ?? null,
            segmentId: $data['segment_id'] ?? null,
            status: $data['status'] ?? null,
            createdAt: $data['created_at'] ?? null,
            scheduledAt: $data['scheduled_at'] ?? null,
            sentAt: $data['sent_at'] ?? null,
            topicId: $data['topic_id'] ?? null,
            from: $data['from'] ?? null,
            subject: $data['subject'] ?? null,
            replyTo: $data['reply_to'] ?? null,
            previewText: $data['preview_text'] ?? null,
            text: $data['text'] ?? null,
            html: $data['html'] ?? null,
        );
    }
}
