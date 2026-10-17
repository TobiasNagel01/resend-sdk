<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Emails;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Attachment;

/**
 * Retrieve a single attachment for a sent email
 *
 * GET /emails/{email_id}/attachments/{attachment_id}
 *
 * @generated from the Resend OpenAPI spec (emails/get-attachment). Do not edit by hand, run `composer generate` instead.
 */
class GetEmailAttachmentRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $emailId  The ID of the email.
     * @param  string  $attachmentId  The ID of the attachment.
     */
    public function __construct(
        public readonly string $emailId,
        public readonly string $attachmentId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/emails/'.rawurlencode($this->emailId).'/attachments/'.rawurlencode($this->attachmentId);
    }

    public function createDtoFromResponse(Response $response): Attachment
    {
        return Attachment::fromArray($response->json());
    }
}
