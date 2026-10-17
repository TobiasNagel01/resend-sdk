<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Topics\CreateTopicRequest;
use TobiasNagel01\ResendSdk\Requests\Topics\GetTopicRequest;
use TobiasNagel01\ResendSdk\Requests\Topics\ListTopicsRequest;
use TobiasNagel01\ResendSdk\Requests\Topics\RemoveTopicRequest;
use TobiasNagel01\ResendSdk\Requests\Topics\UpdateTopicRequest;

/**
 * Topics endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Topics extends BaseResource
{
    /**
     * Create a new topic
     *
     * @param  string  $name  The name of the topic. Max 50 characters.
     * @param  'opt_in'|'opt_out'  $defaultSubscription  The default subscription status for the topic. Cannot be changed after creation.
     * @param  string|null  $description  A description of the topic. Max 200 characters.
     * @param  'public'|'private'|null  $visibility  The visibility of the topic. Public topics are visible to all contacts on the unsubscribe page. Private topics are only visible to opted-in contacts.
     */
    public function create(
        string $name,
        string $defaultSubscription,
        ?string $description = null,
        ?string $visibility = null,
    ): Response {
        return $this->connector->send(new CreateTopicRequest(
            $name,
            $defaultSubscription,
            $description,
            $visibility,
        ));
    }

    /**
     * Retrieve a list of topics
     *
     * `$response->dto()` returns a ListResponse<Topic>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListTopicsRequest($limit, $after, $before));
    }

    /**
     * Retrieve a single topic
     *
     * `$response->dto()` returns a Topic.
     *
     * @param  string  $id  The Topic ID.
     */
    public function get(string $id): Response
    {
        return $this->connector->send(new GetTopicRequest($id));
    }

    /**
     * Update an existing topic
     *
     * @param  string  $id  The Topic ID.
     * @param  string|null  $name  The name of the topic. Max 50 characters.
     * @param  string|null  $description  A description of the topic. Max 200 characters.
     * @param  'public'|'private'|null  $visibility  The visibility of the topic.
     */
    public function update(
        string $id,
        ?string $name = null,
        ?string $description = null,
        ?string $visibility = null,
    ): Response {
        return $this->connector->send(new UpdateTopicRequest(
            $id,
            $name,
            $description,
            $visibility,
        ));
    }

    /**
     * Remove an existing topic
     *
     * @param  string  $id  The Topic ID.
     */
    public function remove(string $id): Response
    {
        return $this->connector->send(new RemoveTopicRequest($id));
    }
}
