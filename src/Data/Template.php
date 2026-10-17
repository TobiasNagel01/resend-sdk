<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (templates/list, templates/get). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Template
{
    /**
     * @param  string|null  $id  The ID of the template.
     * @param  string|null  $name  The name of the template.
     * @param  'draft'|'published'|null  $status  The publication status of the template.
     * @param  string|null  $publishedAt  Timestamp indicating when the template was published.
     * @param  string|null  $createdAt  Timestamp indicating when the template was created.
     * @param  string|null  $updatedAt  Timestamp indicating when the template was last updated.
     * @param  string|null  $alias  The alias of the template.
     * @param  string|null  $object  The type of object.
     * @param  string|null  $currentVersionId  The ID of the current version of the template.
     * @param  string|null  $from  Sender email address. To include a friendly name, use the format "Your Name <sender@domain.com>".
     * @param  string|null  $subject  Email subject.
     * @param  list<string>|null  $replyTo  Reply-to email addresses.
     * @param  string|null  $html  The HTML version of the template.
     * @param  string|null  $text  The plain text version of the template.
     * @param  list<TemplateVariable>|null  $variables
     * @param  bool|null  $hasUnpublishedVersions  Indicates whether the template has unpublished versions.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $status = null,
        public ?string $publishedAt = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
        public ?string $alias = null,
        public ?string $object = null,
        public ?string $currentVersionId = null,
        public ?string $from = null,
        public ?string $subject = null,
        public ?array $replyTo = null,
        public ?string $html = null,
        public ?string $text = null,
        public ?array $variables = null,
        public ?bool $hasUnpublishedVersions = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            status: $data['status'] ?? null,
            publishedAt: $data['published_at'] ?? null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
            alias: $data['alias'] ?? null,
            object: $data['object'] ?? null,
            currentVersionId: $data['current_version_id'] ?? null,
            from: $data['from'] ?? null,
            subject: $data['subject'] ?? null,
            replyTo: $data['reply_to'] ?? null,
            html: $data['html'] ?? null,
            text: $data['text'] ?? null,
            variables: isset($data['variables']) ? array_map(TemplateVariable::fromArray(...), $data['variables']) : null,
            hasUnpublishedVersions: $data['has_unpublished_versions'] ?? null,
        );
    }
}
