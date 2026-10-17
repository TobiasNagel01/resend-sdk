<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Contacts;

use Psr\Http\Message\StreamInterface;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasMultipartBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a contact import
 *
 * POST /contacts/imports
 *
 * @generated from the Resend OpenAPI spec (contacts/create-import). Do not edit by hand, run `composer generate` instead.
 */
class CreateContactImportRequest extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    /**
     * @param  resource|StreamInterface|string  $file  CSV file to import. Maximum size is 50MB.
     * @param  array<mixed>|string|null  $columnMap  JSON-encoded object mapping contact fields and custom property keys to CSV column names. Supports `email`, `first_name`, `last_name`, `unsubscribed`, and `properties`. Custom property mappings can include `type` as `string`, `number`, or `boolean`; defaults to `string`.
     * @param  'upsert'|'skip'|null  $onConflict  Strategy to use when an imported contact already exists.
     * @param  array<mixed>|string|null  $segments  JSON-encoded array of segments to add imported contacts to.
     * @param  array<mixed>|string|null  $topics  JSON-encoded array of topic subscriptions to apply to imported contacts. Each `subscription` must be `opt_in` or `opt_out`.
     * @param  string  $fileName  Filename sent with the `file` upload.
     */
    public function __construct(
        public readonly mixed $file,
        public readonly array|string|null $columnMap = null,
        public readonly ?string $onConflict = null,
        public readonly array|string|null $segments = null,
        public readonly array|string|null $topics = null,
        public readonly string $fileName = 'contacts.csv',
    ) {}

    public function resolveEndpoint(): string
    {
        return '/contacts/imports';
    }

    protected function defaultBody(): array
    {
        return Payload::multipart(
            fields: [
                'column_map' => Payload::json($this->columnMap),
                'on_conflict' => $this->onConflict,
                'segments' => Payload::json($this->segments),
                'topics' => Payload::json($this->topics),
            ],
            files: [
                'file' => [$this->file, $this->fileName],
            ],
        );
    }
}
