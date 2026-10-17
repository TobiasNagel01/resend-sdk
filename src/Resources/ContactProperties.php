<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\ContactProperties\CreateContactPropertyRequest;
use TobiasNagel01\ResendSdk\Requests\ContactProperties\GetContactPropertyRequest;
use TobiasNagel01\ResendSdk\Requests\ContactProperties\ListContactPropertiesRequest;
use TobiasNagel01\ResendSdk\Requests\ContactProperties\RemoveContactPropertyRequest;
use TobiasNagel01\ResendSdk\Requests\ContactProperties\UpdateContactPropertyRequest;

/**
 * ContactProperties endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class ContactProperties extends BaseResource
{
    /**
     * Create a new contact property
     *
     * @param  string  $key  The property key. Max length is 50 characters. Only alphanumeric characters and underscores are allowed.
     * @param  'string'|'number'  $type  The property type.
     * @param  string|int|float|null  $fallbackValue  The default value to use when the property is not set for a contact. Must match the type specified in the type field.
     */
    public function create(string $key, string $type, string|int|float|null $fallbackValue = null): Response
    {
        return $this->connector->send(new CreateContactPropertyRequest($key, $type, $fallbackValue));
    }

    /**
     * Retrieve a list of contact properties
     *
     * `$response->dto()` returns a ListResponse<ContactProperty>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListContactPropertiesRequest($limit, $after, $before));
    }

    /**
     * Retrieve a single contact property
     *
     * `$response->dto()` returns a ContactProperty.
     *
     * @param  string  $id  The Contact Property ID.
     */
    public function get(string $id): Response
    {
        return $this->connector->send(new GetContactPropertyRequest($id));
    }

    /**
     * Update an existing contact property
     *
     * @param  string  $id  The Contact Property ID.
     * @param  string|int|float|null  $fallbackValue  The default value to use when the property is not set for a contact. Must match the type of the property.
     */
    public function update(string $id, string|int|float|null $fallbackValue = null): Response
    {
        return $this->connector->send(new UpdateContactPropertyRequest($id, $fallbackValue));
    }

    /**
     * Remove an existing contact property
     *
     * @param  string  $id  The Contact Property ID.
     */
    public function remove(string $id): Response
    {
        return $this->connector->send(new RemoveContactPropertyRequest($id));
    }
}
