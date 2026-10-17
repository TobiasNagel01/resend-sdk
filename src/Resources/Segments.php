<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Segments\CreateSegmentRequest;
use TobiasNagel01\ResendSdk\Requests\Segments\GetSegmentRequest;
use TobiasNagel01\ResendSdk\Requests\Segments\ListSegmentContactsRequest;
use TobiasNagel01\ResendSdk\Requests\Segments\ListSegmentsRequest;
use TobiasNagel01\ResendSdk\Requests\Segments\RemoveSegmentRequest;
use TobiasNagel01\ResendSdk\Requests\Segments\UpdateSegmentRequest;

/**
 * Segments endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Segments extends BaseResource
{
    /**
     * Create a new segment
     *
     * @param  string  $name  The name of the segment.
     * @param  string|null  $audienceId  The ID of the audience this segment belongs to.
     * @param  array<string, mixed>|null  $filter  Filter conditions for the segment.
     */
    public function create(string $name, ?string $audienceId = null, ?array $filter = null): Response
    {
        return $this->connector->send(new CreateSegmentRequest($name, $audienceId, $filter));
    }

    /**
     * Retrieve a list of segments
     *
     * `$response->dto()` returns a ListResponse<Segment>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListSegmentsRequest($limit, $after, $before));
    }

    /**
     * Retrieve a single segment
     *
     * `$response->dto()` returns a Segment.
     *
     * @param  string  $id  The Segment ID.
     */
    public function get(string $id): Response
    {
        return $this->connector->send(new GetSegmentRequest($id));
    }

    /**
     * Update an existing segment
     *
     * @param  string  $id  The Segment ID.
     * @param  string  $name  The name of the segment.
     */
    public function update(string $id, string $name): Response
    {
        return $this->connector->send(new UpdateSegmentRequest($id, $name));
    }

    /**
     * Remove an existing segment
     *
     * @param  string  $id  The Segment ID.
     */
    public function remove(string $id): Response
    {
        return $this->connector->send(new RemoveSegmentRequest($id));
    }

    /**
     * Retrieve a list of contacts in a segment
     *
     * `$response->dto()` returns a ListResponse<Contact>.
     *
     * @param  string  $id  The Segment ID.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function listContacts(
        string $id,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListSegmentContactsRequest(
            $id,
            $limit,
            $after,
            $before,
        ));
    }
}
