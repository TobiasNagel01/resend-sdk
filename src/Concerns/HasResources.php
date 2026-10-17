<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Concerns;

use TobiasNagel01\ResendSdk\Resources\ApiKeys;
use TobiasNagel01\ResendSdk\Resources\Audiences;
use TobiasNagel01\ResendSdk\Resources\Automations;
use TobiasNagel01\ResendSdk\Resources\Broadcasts;
use TobiasNagel01\ResendSdk\Resources\ContactProperties;
use TobiasNagel01\ResendSdk\Resources\Contacts;
use TobiasNagel01\ResendSdk\Resources\Domains;
use TobiasNagel01\ResendSdk\Resources\Emails;
use TobiasNagel01\ResendSdk\Resources\Events;
use TobiasNagel01\ResendSdk\Resources\Inboxes;
use TobiasNagel01\ResendSdk\Resources\Logs;
use TobiasNagel01\ResendSdk\Resources\OAuth;
use TobiasNagel01\ResendSdk\Resources\Segments;
use TobiasNagel01\ResendSdk\Resources\Suppressions;
use TobiasNagel01\ResendSdk\Resources\Templates;
use TobiasNagel01\ResendSdk\Resources\Topics;
use TobiasNagel01\ResendSdk\Resources\Usage;
use TobiasNagel01\ResendSdk\Resources\Webhooks;

/**
 * Resource accessors of the Resend connector.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
trait HasResources
{
    public function emails(): Emails
    {
        return new Emails($this);
    }

    public function domains(): Domains
    {
        return new Domains($this);
    }

    public function apiKeys(): ApiKeys
    {
        return new ApiKeys($this);
    }

    public function oauth(): OAuth
    {
        return new OAuth($this);
    }

    public function templates(): Templates
    {
        return new Templates($this);
    }

    public function audiences(): Audiences
    {
        return new Audiences($this);
    }

    public function contacts(): Contacts
    {
        return new Contacts($this);
    }

    public function broadcasts(): Broadcasts
    {
        return new Broadcasts($this);
    }

    public function webhooks(): Webhooks
    {
        return new Webhooks($this);
    }

    public function segments(): Segments
    {
        return new Segments($this);
    }

    public function topics(): Topics
    {
        return new Topics($this);
    }

    public function contactProperties(): ContactProperties
    {
        return new ContactProperties($this);
    }

    public function logs(): Logs
    {
        return new Logs($this);
    }

    public function automations(): Automations
    {
        return new Automations($this);
    }

    public function events(): Events
    {
        return new Events($this);
    }

    public function suppressions(): Suppressions
    {
        return new Suppressions($this);
    }

    public function usage(): Usage
    {
        return new Usage($this);
    }

    public function inboxes(): Inboxes
    {
        return new Inboxes($this);
    }
}
