<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (schema:DomainRecord). Do not edit by hand, run `composer generate` instead.
 */
final readonly class DomainRecord
{
    /**
     * @param  'SPF'|'DKIM'|'Receiving'|'Tracking'|'TrackingCAA'|null  $record  The type of record (SPF for sending, DKIM for sending, Receiving for inbound emails, Tracking & TrackingCAA for click and open tracking).
     * @param  string|null  $name  The name of the DNS record.
     * @param  'MX'|'TXT'|'CNAME'|'CAA'|null  $type  The DNS record type.
     * @param  string|null  $ttl  The time to live for the record.
     * @param  'pending'|'verified'|'failed'|'temporary_failure'|'not_started'|null  $status  The status of the record.
     * @param  string|null  $value  The value of the record.
     * @param  int|null  $priority  The priority of the record (only applicable for MX records).
     */
    public function __construct(
        public ?string $record = null,
        public ?string $name = null,
        public ?string $type = null,
        public ?string $ttl = null,
        public ?string $status = null,
        public ?string $value = null,
        public ?int $priority = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            record: $data['record'] ?? null,
            name: $data['name'] ?? null,
            type: $data['type'] ?? null,
            ttl: $data['ttl'] ?? null,
            status: $data['status'] ?? null,
            value: $data['value'] ?? null,
            priority: $data['priority'] ?? null,
        );
    }
}
