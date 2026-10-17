<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (emails/list-attachments, emails/get-attachment, emails/list-receiving-attachments, emails/get-receiving-attachment). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Attachment
{
    /**
     * @param  string|null  $id  The ID of the attachment.
     * @param  string|null  $filename  The filename of the attachment.
     * @param  string|null  $contentType  The MIME type of the attachment.
     * @param  string|null  $contentId  The content ID for inline attachments.
     * @param  'inline'|'attachment'|null  $contentDisposition  How the attachment should be displayed.
     * @param  string|null  $downloadUrl  Signed URL to download the attachment content.
     * @param  string|null  $expiresAt  Timestamp when the download URL expires.
     * @param  int|null  $size  Size of the attachment in bytes.
     * @param  string|null  $object  The type of object.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $filename = null,
        public ?string $contentType = null,
        public ?string $contentId = null,
        public ?string $contentDisposition = null,
        public ?string $downloadUrl = null,
        public ?string $expiresAt = null,
        public ?int $size = null,
        public ?string $object = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            filename: $data['filename'] ?? null,
            contentType: $data['content_type'] ?? null,
            contentId: $data['content_id'] ?? null,
            contentDisposition: $data['content_disposition'] ?? null,
            downloadUrl: $data['download_url'] ?? null,
            expiresAt: $data['expires_at'] ?? null,
            size: $data['size'] ?? null,
            object: $data['object'] ?? null,
        );
    }
}
