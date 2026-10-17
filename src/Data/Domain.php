<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (domains/list, domains/get). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Domain
{
    /**
     * @param  string|null  $id  The ID of the domain.
     * @param  string|null  $name  The name of the domain.
     * @param  'pending'|'verified'|'failed'|'not_started'|'partially_verified'|'partially_failed'|null  $status  The status of the domain.
     * @param  string|null  $createdAt  The date and time the domain was created.
     * @param  string|null  $region  The region where the domain is hosted.
     * @param  bool|null  $openTracking  Whether open tracking is enabled for this domain.
     * @param  bool|null  $clickTracking  Whether click tracking is enabled for this domain.
     * @param  array{sending?: 'enabled'|'disabled', receiving?: 'enabled'|'disabled'}|null  $capabilities  Configure the domain capabilities for sending and receiving emails. At least one capability must be enabled.
     * @param  string|null  $object  The type of object.
     * @param  string|null  $trackingSubdomain  The subdomain used for click and open tracking.
     * @param  list<DomainRecord>|null  $records
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $status = null,
        public ?string $createdAt = null,
        public ?string $region = null,
        public ?bool $openTracking = null,
        public ?bool $clickTracking = null,
        public ?array $capabilities = null,
        public ?string $object = null,
        public ?string $trackingSubdomain = null,
        public ?array $records = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            status: $data['status'] ?? null,
            createdAt: $data['created_at'] ?? null,
            region: $data['region'] ?? null,
            openTracking: $data['open_tracking'] ?? null,
            clickTracking: $data['click_tracking'] ?? null,
            capabilities: $data['capabilities'] ?? null,
            object: $data['object'] ?? null,
            trackingSubdomain: $data['tracking_subdomain'] ?? null,
            records: isset($data['records']) ? array_map(DomainRecord::fromArray(...), $data['records']) : null,
        );
    }
}
