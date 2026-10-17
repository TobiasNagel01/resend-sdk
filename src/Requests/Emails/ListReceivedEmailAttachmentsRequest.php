<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Emails;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Attachment;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of attachments for a received email
 *
 * GET /emails/receiving/{email_id}/attachments
 *
 * @generated from the Resend OpenAPI spec (emails/list-receiving-attachments). Do not edit by hand, run `composer generate` instead.
 */
class ListReceivedEmailAttachmentsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $emailId  The ID of the received email.
     * @param  int|null  $limit  Maximum number of attachments to return.
     * @param  string|null  $after  Pagination cursor to fetch results after this attachment ID. Cannot be used with 'before'.
     * @param  string|null  $before  Pagination cursor to fetch results before this attachment ID. Cannot be used with 'after'.
     */
    public function __construct(
        public readonly string $emailId,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/emails/receiving/'.rawurlencode($this->emailId).'/attachments';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'limit' => $this->limit,
            'after' => $this->after,
            'before' => $this->before,
        ]);
    }

    /**
     * @return ListResponse<Attachment>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), Attachment::fromArray(...));
    }
}
