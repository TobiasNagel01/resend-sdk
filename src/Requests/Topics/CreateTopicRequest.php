<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Topics;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a new topic
 *
 * POST /topics
 *
 * @generated from the Resend OpenAPI spec (topics/create). Do not edit by hand, run `composer generate` instead.
 */
class CreateTopicRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $name  The name of the topic. Max 50 characters.
     * @param  'opt_in'|'opt_out'  $defaultSubscription  The default subscription status for the topic. Cannot be changed after creation.
     * @param  string|null  $description  A description of the topic. Max 200 characters.
     * @param  'public'|'private'|null  $visibility  The visibility of the topic. Public topics are visible to all contacts on the unsubscribe page. Private topics are only visible to opted-in contacts.
     */
    public function __construct(
        public readonly string $name,
        public readonly string $defaultSubscription,
        public readonly ?string $description = null,
        public readonly ?string $visibility = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/topics';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'default_subscription' => $this->defaultSubscription,
            'description' => $this->description,
            'visibility' => $this->visibility,
        ]);
    }
}
