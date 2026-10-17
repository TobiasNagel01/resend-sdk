<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Omit;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an existing draft
 *
 * Updates the content of an unsent draft. Omitted fields are left unchanged. Send at least one of `to`, `cc`, `bcc`, `subject`, `text`, `html` or `attachments`. Sending `attachments` replaces every attachment on the draft. A request that sets `text` or `html` replaces the whole body. The body part you omit from that request becomes `null`. The merged draft must still contain at least one non-empty field, and its combined recipients cannot exceed 50. A draft that was already sent, or that changed during the request, returns a 409. The response holds only the Draft ID. Retrieve the draft to read its content.
 *
 * PATCH /inboxes/{inbox_id}/drafts/{draft_id}
 *
 * @generated from the Resend OpenAPI spec (inboxes/update-draft). Do not edit by hand, run `composer generate` instead.
 */
class UpdateInboxDraftRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $draftId  The Draft ID.
     * @param  string|list<string>|null|Omit  $to  The recipients. For multiple addresses, send an array of strings. Each value can include a friendly name. Pass `null` to clear. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $cc  The CC recipients. Pass `null` or `[]` to clear. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|list<string>|null|Omit  $bcc  The BCC recipients. Pass `null` or `[]` to clear. Each address is `email@example.com` or `Name <email@example.com>`. An address that is not valid returns a 422.
     * @param  string|null|Omit  $subject  The subject. Max 2000 characters. Cannot be only whitespace or contain a line break. Pass `null` to clear.
     * @param  string|null|Omit  $html  The HTML body. Pass `null` to clear.
     * @param  string|null|Omit  $text  The plain text body. Pass `null` to clear.
     * @param  list<array{content: string, filename: string, content_type: string}>|null|Omit  $attachments  Files to store on the draft. Each one needs `content`, `filename` and `content_type`. A `path` without `content` returns a 422, and when both are sent, `path` is ignored. A `content_id` returns a 422. The files on a draft can total at most 25 MB. An empty file or a blocked file type returns a 422. Sending the field replaces every attachment on the draft. Send `[]` to remove them all. `null` also removes them all.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $draftId,
        public readonly string|array|Omit|null $to = Omit::Value,
        public readonly string|array|Omit|null $cc = Omit::Value,
        public readonly string|array|Omit|null $bcc = Omit::Value,
        public readonly string|Omit|null $subject = Omit::Value,
        public readonly string|Omit|null $html = Omit::Value,
        public readonly string|Omit|null $text = Omit::Value,
        public readonly array|Omit|null $attachments = Omit::Value,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/drafts/'.rawurlencode($this->draftId);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'to' => $this->to,
            'cc' => $this->cc,
            'bcc' => $this->bcc,
            'subject' => $this->subject,
            'html' => $this->html,
            'text' => $this->text,
            'attachments' => $this->attachments,
        ], nullable: ['to', 'cc', 'bcc', 'subject', 'html', 'text', 'attachments']);
    }
}
