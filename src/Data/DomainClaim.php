<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (domains/create-claim, domains/get-claim, domains/verify-claim). Do not edit by hand, run `composer generate` instead.
 */
final readonly class DomainClaim
{
    /**
     * @param  string|null  $object  The type of object.
     * @param  string|null  $id  The ID of the claim.
     * @param  string|null  $name  The name of the domain being claimed.
     * @param  'pending'|'verified'|'completed'|'blocked'|'expired'|'superseded'|'canceled'|'failed'|null  $status  The status of the claim.
     * @param  string|null  $domainId  The ID of the placeholder domain created for the claim.
     * @param  'us-east-1'|'eu-west-1'|'sa-east-1'|'ap-northeast-1'|null  $region  The region where the claimed domain will send from.
     * @param  array{type?: 'TXT', name?: string, value?: string, ttl?: string}|null  $record  The TXT record to add to your DNS to prove ownership of the claimed domain.
     * @param  'grace_period'|'recent_owner_activity'|'pending_scheduled_emails'|null  $blockedReason  Why the claim is currently blocked, if applicable.
     * @param  string|null  $failureReason  Why the claim failed, if applicable.
     * @param  string|null  $createdAt  The date and time the claim was created.
     * @param  string|null  $expiresAt  The date and time the claim expires if not verified.
     */
    public function __construct(
        public ?string $object = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?string $status = null,
        public ?string $domainId = null,
        public ?string $region = null,
        public ?array $record = null,
        public ?string $blockedReason = null,
        public ?string $failureReason = null,
        public ?string $createdAt = null,
        public ?string $expiresAt = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            object: $data['object'] ?? null,
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            status: $data['status'] ?? null,
            domainId: $data['domain_id'] ?? null,
            region: $data['region'] ?? null,
            record: $data['record'] ?? null,
            blockedReason: $data['blocked_reason'] ?? null,
            failureReason: $data['failure_reason'] ?? null,
            createdAt: $data['created_at'] ?? null,
            expiresAt: $data['expires_at'] ?? null,
        );
    }
}
