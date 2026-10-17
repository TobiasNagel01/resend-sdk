<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Broadcasts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Duplicate a broadcast
 *
 * Creates a new draft broadcast with the same segment, topic, sender, subject, reply-to, preview text, and content as the source. The copy is named after the source with " (copy)" appended, truncated to 70 characters.
 *
 * POST /broadcasts/{id}/duplicate
 *
 * @generated from the Resend OpenAPI spec (broadcasts/duplicate). Do not edit by hand, run `composer generate` instead.
 */
class DuplicateBroadcastRequest extends Request
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
        return '/broadcasts/'.rawurlencode($this->id).'/duplicate';
    }
}
