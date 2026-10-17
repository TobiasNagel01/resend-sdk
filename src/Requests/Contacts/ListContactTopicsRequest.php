<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve topics for a contact
 *
 * GET /contacts/{contact_id}/topics
 *
 * @generated from the Resend OpenAPI spec (contacts/list-topics). Do not edit by hand, run `composer generate` instead.
 */
class ListContactTopicsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $contactId  The Contact ID or email address.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function __construct(
        public readonly string $contactId,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/contacts/'.rawurlencode($this->contactId).'/topics';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'limit' => $this->limit,
            'after' => $this->after,
            'before' => $this->before,
        ]);
    }
}
