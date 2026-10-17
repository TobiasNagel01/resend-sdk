<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove a contact from a segment
 *
 * DELETE /contacts/{contact_id}/segments/{segment_id}
 *
 * @generated from the Resend OpenAPI spec (contacts/remove-segment). Do not edit by hand, run `composer generate` instead.
 */
class RemoveContactSegmentRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $contactId  The Contact ID or email address.
     * @param  string  $segmentId  The Segment ID.
     */
    public function __construct(
        public readonly string $contactId,
        public readonly string $segmentId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/contacts/'.rawurlencode($this->contactId).'/segments/'.rawurlencode($this->segmentId);
    }
}
