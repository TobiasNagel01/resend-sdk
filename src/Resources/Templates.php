<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Templates\CreateTemplateRequest;
use TobiasNagel01\ResendSdk\Requests\Templates\DuplicateTemplateRequest;
use TobiasNagel01\ResendSdk\Requests\Templates\GetTemplateRequest;
use TobiasNagel01\ResendSdk\Requests\Templates\ListTemplatesRequest;
use TobiasNagel01\ResendSdk\Requests\Templates\PublishTemplateRequest;
use TobiasNagel01\ResendSdk\Requests\Templates\RemoveTemplateRequest;
use TobiasNagel01\ResendSdk\Requests\Templates\UpdateTemplateRequest;

/**
 * Templates endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Templates extends BaseResource
{
    /**
     * Create a template
     *
     * @param  string  $name  The name of the template.
     * @param  string  $html  The HTML version of the template.
     * @param  string|null  $alias  The alias of the template.
     * @param  string|null  $from  Sender email address. To include a friendly name, use the format "Your Name <sender@domain.com>".
     * @param  string|null  $subject  Email subject.
     * @param  list<string>|null  $replyTo  Reply-to email addresses.
     * @param  string|null  $text  The plain text version of the template.
     * @param  list<array{key: string, type: 'string'|'number'|'boolean'|'object'|'list', fallback_value?: string|int|float|bool|array<string, mixed>|list<mixed>}>|null  $variables
     */
    public function create(
        string $name,
        string $html,
        ?string $alias = null,
        ?string $from = null,
        ?string $subject = null,
        ?array $replyTo = null,
        ?string $text = null,
        ?array $variables = null,
    ): Response {
        return $this->connector->send(new CreateTemplateRequest(
            $name,
            $html,
            $alias,
            $from,
            $subject,
            $replyTo,
            $text,
            $variables,
        ));
    }

    /**
     * Retrieve a list of templates
     *
     * `$response->dto()` returns a ListResponse<Template>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListTemplatesRequest($limit, $after, $before));
    }

    /**
     * Retrieve a single template
     *
     * `$response->dto()` returns a Template.
     *
     * @param  string  $id  The Template ID or alias.
     */
    public function get(string $id): Response
    {
        return $this->connector->send(new GetTemplateRequest($id));
    }

    /**
     * Update an existing template
     *
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
    public function update(
        string $id,
        ?string $name = null,
        ?string $alias = null,
        ?string $from = null,
        ?string $subject = null,
        ?array $replyTo = null,
        ?string $html = null,
        ?string $text = null,
        ?array $variables = null,
    ): Response {
        return $this->connector->send(new UpdateTemplateRequest(
            $id,
            $name,
            $alias,
            $from,
            $subject,
            $replyTo,
            $html,
            $text,
            $variables,
        ));
    }

    /**
     * Remove an existing template
     *
     * @param  string  $id  The Template ID or alias.
     */
    public function remove(string $id): Response
    {
        return $this->connector->send(new RemoveTemplateRequest($id));
    }

    /**
     * Publish a template
     *
     * @param  string  $id  The Template ID or alias.
     */
    public function publish(string $id): Response
    {
        return $this->connector->send(new PublishTemplateRequest($id));
    }

    /**
     * Duplicate a template
     *
     * @param  string  $id  The Template ID or alias.
     */
    public function duplicate(string $id): Response
    {
        return $this->connector->send(new DuplicateTemplateRequest($id));
    }
}
