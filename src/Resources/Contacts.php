<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Psr\Http\Message\StreamInterface;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Contacts\AddContactSegmentRequest;
use TobiasNagel01\ResendSdk\Requests\Contacts\CreateContactImportRequest;
use TobiasNagel01\ResendSdk\Requests\Contacts\CreateContactRequest;
use TobiasNagel01\ResendSdk\Requests\Contacts\GetContactImportRequest;
use TobiasNagel01\ResendSdk\Requests\Contacts\GetContactRequest;
use TobiasNagel01\ResendSdk\Requests\Contacts\ListContactImportsRequest;
use TobiasNagel01\ResendSdk\Requests\Contacts\ListContactSegmentsRequest;
use TobiasNagel01\ResendSdk\Requests\Contacts\ListContactsRequest;
use TobiasNagel01\ResendSdk\Requests\Contacts\ListContactTopicsRequest;
use TobiasNagel01\ResendSdk\Requests\Contacts\RemoveContactRequest;
use TobiasNagel01\ResendSdk\Requests\Contacts\RemoveContactSegmentRequest;
use TobiasNagel01\ResendSdk\Requests\Contacts\UpdateContactRequest;
use TobiasNagel01\ResendSdk\Requests\Contacts\UpdateContactTopicsRequest;

/**
 * Contacts endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Contacts extends BaseResource
{
    /**
     * Create a new contact
     *
     * @param  string  $email  Email address of the contact.
     * @param  string|null  $firstName  First name of the contact.
     * @param  string|null  $lastName  Last name of the contact.
     * @param  bool|null  $unsubscribed  The Contact's global subscription status. If set to true, the contact will be unsubscribed from all Broadcasts.
     * @param  array<string, mixed>|null  $properties  A map of custom property keys and values to create.
     * @param  list<array{id?: string}>|null  $segments  Array of segment IDs to add the contact to.
     * @param  list<array{id?: string, subscription?: 'opt_in'|'opt_out'}>|null  $topics  Array of topic subscriptions for the contact.
     * @param  string|null  $audienceId  Unique identifier of the audience to which the contact belongs.
     */
    public function create(
        string $email,
        ?string $firstName = null,
        ?string $lastName = null,
        ?bool $unsubscribed = null,
        ?array $properties = null,
        ?array $segments = null,
        ?array $topics = null,
        ?string $audienceId = null,
    ): Response {
        return $this->connector->send(new CreateContactRequest(
            $email,
            $firstName,
            $lastName,
            $unsubscribed,
            $properties,
            $segments,
            $topics,
            $audienceId,
        ));
    }

    /**
     * Retrieve a list of contacts
     *
     * `$response->dto()` returns a ListResponse<Contact>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListContactsRequest($limit, $after, $before));
    }

    /**
     * Create a contact import
     *
     * @param  resource|StreamInterface|string  $file  CSV file to import. Maximum size is 50MB.
     * @param  array<mixed>|string|null  $columnMap  JSON-encoded object mapping contact fields and custom property keys to CSV column names. Supports `email`, `first_name`, `last_name`, `unsubscribed`, and `properties`. Custom property mappings can include `type` as `string`, `number`, or `boolean`; defaults to `string`.
     * @param  'upsert'|'skip'|null  $onConflict  Strategy to use when an imported contact already exists.
     * @param  array<mixed>|string|null  $segments  JSON-encoded array of segments to add imported contacts to.
     * @param  array<mixed>|string|null  $topics  JSON-encoded array of topic subscriptions to apply to imported contacts. Each `subscription` must be `opt_in` or `opt_out`.
     * @param  string  $fileName  Filename sent with the `file` upload.
     */
    public function createImport(
        mixed $file,
        array|string|null $columnMap = null,
        ?string $onConflict = null,
        array|string|null $segments = null,
        array|string|null $topics = null,
        string $fileName = 'contacts.csv',
    ): Response {
        return $this->connector->send(new CreateContactImportRequest(
            $file,
            $columnMap,
            $onConflict,
            $segments,
            $topics,
            $fileName,
        ));
    }

    /**
     * Retrieve a list of contact imports
     *
     * `$response->dto()` returns a ListResponse<ContactImport>.
     *
     * @param  'queued'|'in_progress'|'completed'|'failed'|null  $status  Filter contact imports by status.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function listImports(
        ?string $status = null,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListContactImportsRequest(
            $status,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Retrieve a single contact import
     *
     * `$response->dto()` returns a ContactImport.
     *
     * @param  string  $id  The Contact Import ID.
     */
    public function getImport(string $id): Response
    {
        return $this->connector->send(new GetContactImportRequest($id));
    }

    /**
     * Retrieve a single contact by ID or email
     *
     * `$response->dto()` returns a Contact.
     *
     * @param  string  $id  The Contact ID or email address.
     */
    public function get(string $id): Response
    {
        return $this->connector->send(new GetContactRequest($id));
    }

    /**
     * Update a single contact by ID or email
     *
     * @param  string  $id  The Contact ID or email address.
     * @param  string|null  $email  Email address of the contact.
     * @param  string|null  $firstName  First name of the contact.
     * @param  string|null  $lastName  Last name of the contact.
     * @param  bool|null  $unsubscribed  The Contact's global subscription status. If set to true, the contact will be unsubscribed from all Broadcasts.
     * @param  array<string, mixed>|null  $properties  A map of custom property keys and values to update.
     */
    public function update(
        string $id,
        ?string $email = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?bool $unsubscribed = null,
        ?array $properties = null,
    ): Response {
        return $this->connector->send(new UpdateContactRequest(
            $id,
            $email,
            $firstName,
            $lastName,
            $unsubscribed,
            $properties,
        ));
    }

    /**
     * Remove an existing contact by ID or email
     *
     * @param  string  $id  The Contact ID or email address.
     */
    public function remove(string $id): Response
    {
        return $this->connector->send(new RemoveContactRequest($id));
    }

    /**
     * Retrieve a list of segments for a contact
     *
     * `$response->dto()` returns a ListResponse<Segment>.
     *
     * @param  string  $contactId  The Contact ID or email address.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function listSegments(
        string $contactId,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListContactSegmentsRequest(
            $contactId,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Add a contact to a segment
     *
     * @param  string  $contactId  The Contact ID or email address.
     * @param  string  $segmentId  The Segment ID.
     */
    public function addSegment(string $contactId, string $segmentId): Response
    {
        return $this->connector->send(new AddContactSegmentRequest($contactId, $segmentId));
    }

    /**
     * Remove a contact from a segment
     *
     * @param  string  $contactId  The Contact ID or email address.
     * @param  string  $segmentId  The Segment ID.
     */
    public function removeSegment(string $contactId, string $segmentId): Response
    {
        return $this->connector->send(new RemoveContactSegmentRequest($contactId, $segmentId));
    }

    /**
     * Retrieve topics for a contact
     *
     * @param  string  $contactId  The Contact ID or email address.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function listTopics(
        string $contactId,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListContactTopicsRequest(
            $contactId,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Update topics for a contact
     *
     * @param  string  $contactId  The Contact ID or email address.
     * @param  list<array{id?: string, subscription?: 'opt_in'|'opt_out'}>  $topics
     */
    public function updateTopics(string $contactId, array $topics): Response
    {
        return $this->connector->send(new UpdateContactTopicsRequest($contactId, $topics));
    }
}
