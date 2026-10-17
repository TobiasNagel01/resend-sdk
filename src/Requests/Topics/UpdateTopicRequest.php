<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Topics;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an existing topic
 *
 * PATCH /topics/{id}
 *
 * @generated from the Resend OpenAPI spec (topics/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateTopicRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $id  The Topic ID.
     * @param  string|null  $name  The name of the topic. Max 50 characters.
     * @param  string|null  $description  A description of the topic. Max 200 characters.
     * @param  'public'|'private'|null  $visibility  The visibility of the topic.
     */
    public function __construct(
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?string $description = null,
        public readonly ?string $visibility = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/topics/'.rawurlencode($this->id);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'description' => $this->description,
            'visibility' => $this->visibility,
        ]);
    }
}
