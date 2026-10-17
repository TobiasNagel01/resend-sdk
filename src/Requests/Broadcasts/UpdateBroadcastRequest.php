<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Broadcasts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an existing broadcast
 *
 * PATCH /broadcasts/{id}
 *
 * @generated from the Resend OpenAPI spec (broadcasts/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateBroadcastRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
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
    public function __construct(
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?string $audienceId = null,
        public readonly ?string $segmentId = null,
        public readonly ?string $from = null,
        public readonly ?string $subject = null,
        public readonly ?array $replyTo = null,
        public readonly ?string $previewText = null,
        public readonly ?string $html = null,
        public readonly ?string $text = null,
        public readonly ?string $topicId = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/broadcasts/'.rawurlencode($this->id);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'audience_id' => $this->audienceId,
            'segment_id' => $this->segmentId,
            'from' => $this->from,
            'subject' => $this->subject,
            'reply_to' => $this->replyTo,
            'preview_text' => $this->previewText,
            'html' => $this->html,
            'text' => $this->text,
            'topic_id' => $this->topicId,
        ]);
    }
}
