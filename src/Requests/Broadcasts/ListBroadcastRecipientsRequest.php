<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Broadcasts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve broadcast recipients
 *
 * Retrieve the recipients of a broadcast for a given event type, such as who opened, clicked, or bounced.
 *
 * GET /broadcasts/{id}/recipients
 *
 * @generated from the Resend OpenAPI spec (broadcasts/recipients). Do not edit by hand, run `composer generate` instead.
 */
class ListBroadcastRecipientsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $id  The Broadcast ID.
     * @param  'sent'|'delivered'|'opened'|'clicked'|'bounced'|'complained'|'unsubscribed'|'suppressed'  $type  The recipient event type to filter by.
     * @param  string|null  $email  Filter recipients whose email address contains this value.
     * @param  'permanent'|'transient'|'undetermined'|null  $bounceType  Filter bounced recipients by bounce type. Only valid when `type` is `bounced`.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly ?string $email = null,
        public readonly ?string $bounceType = null,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/broadcasts/'.rawurlencode($this->id).'/recipients';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'type' => $this->type,
            'email' => $this->email,
            'bounce_type' => $this->bounceType,
            'limit' => $this->limit,
            'after' => $this->after,
            'before' => $this->before,
        ]);
    }
}
