<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Add a contact to a segment
 *
 * POST /contacts/{contact_id}/segments/{segment_id}
 *
 * @generated from the Resend OpenAPI spec (contacts/add-segment). Do not edit by hand, run `composer generate` instead.
 */
class AddContactSegmentRequest extends Request
{
    protected Method $method = Method::POST;

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
