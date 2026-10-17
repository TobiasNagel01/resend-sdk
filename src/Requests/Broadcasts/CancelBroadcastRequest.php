<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Broadcasts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Cancel a broadcast
 *
 * Cancels a broadcast that is queued or scheduled. Canceling a queued broadcast stops it mid-send; emails already sent are not affected, but no further emails will go out.
 *
 * POST /broadcasts/{id}/cancel
 *
 * @generated from the Resend OpenAPI spec (broadcasts/cancel). Do not edit by hand, run `composer generate` instead.
 */
class CancelBroadcastRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $id  The Broadcast ID.
     */
    public function __construct(
        public readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/broadcasts/'.rawurlencode($this->id).'/cancel';
    }
}
