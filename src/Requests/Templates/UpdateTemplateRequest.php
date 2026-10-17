<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Templates;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an existing template
 *
 * PATCH /templates/{id}
 *
 * @generated from the Resend OpenAPI spec (templates/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateTemplateRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $id  The Template ID or alias.
     * @param  string|null  $name  The name of the template.
     * @param  string|null  $alias  The alias of the template.
     * @param  string|null  $from  Sender email address. To include a friendly name, use the format "Your Name <sender@domain.com>".
     * @param  string|null  $subject  Email subject.
     * @param  list<string>|null  $replyTo  Reply-to email addresses.
     * @param  string|null  $html  The HTML version of the template.
     * @param  string|null  $text  The plain text version of the template.
     * @param  list<array{key: string, type: 'string'|'number'|'boolean'|'object'|'list', fallback_value?: string|int|float|bool|array<string, mixed>|list<mixed>}>|null  $variables
     */
    public function __construct(
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?string $alias = null,
        public readonly ?string $from = null,
        public readonly ?string $subject = null,
        public readonly ?array $replyTo = null,
        public readonly ?string $html = null,
        public readonly ?string $text = null,
        public readonly ?array $variables = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/templates/'.rawurlencode($this->id);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'alias' => $this->alias,
            'from' => $this->from,
            'subject' => $this->subject,
            'reply_to' => $this->replyTo,
            'html' => $this->html,
            'text' => $this->text,
            'variables' => $this->variables,
        ]);
    }
}
