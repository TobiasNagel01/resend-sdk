<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Broadcasts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove an existing broadcast that is in the draft status
 *
 * DELETE /broadcasts/{id}
 *
 * @generated from the Resend OpenAPI spec (broadcasts/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveBroadcastRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $id  The Broadcast ID.
     */
    public function __construct(
        public readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/broadcasts/'.rawurlencode($this->id);
    }
}
