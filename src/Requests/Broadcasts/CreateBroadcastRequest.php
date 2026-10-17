<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Broadcasts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a broadcast
 *
 * POST /broadcasts
 *
 * @generated from the Resend OpenAPI spec (broadcasts/create). Do not edit by hand, run `composer generate` instead.
 */
class CreateBroadcastRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
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
    public function __construct(
        public readonly string $segmentId,
        public readonly string $from,
        public readonly string $subject,
        public readonly ?string $name = null,
        public readonly ?string $audienceId = null,
        public readonly ?array $replyTo = null,
        public readonly ?string $previewText = null,
        public readonly ?string $html = null,
        public readonly ?string $text = null,
        public readonly ?string $topicId = null,
        public readonly ?bool $send = null,
        public readonly ?string $scheduledAt = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/broadcasts';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'segment_id' => $this->segmentId,
            'from' => $this->from,
            'subject' => $this->subject,
            'name' => $this->name,
            'audience_id' => $this->audienceId,
            'reply_to' => $this->replyTo,
            'preview_text' => $this->previewText,
            'html' => $this->html,
            'text' => $this->text,
            'topic_id' => $this->topicId,
            'send' => $this->send,
            'scheduled_at' => $this->scheduledAt,
        ]);
    }
}
