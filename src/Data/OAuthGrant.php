<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (oauth/list-grants). Do not edit by hand, run `composer generate` instead.
 */
final readonly class OAuthGrant
{
    /**
     * @param  string|null  $id  The ID of the OAuth grant.
     * @param  string|null  $clientId  The ID of the OAuth client the grant was issued to.
     * @param  list<string>|null  $scopes  The scopes granted to the OAuth client.
     * @param  string|null  $createdAt  The date and time the OAuth grant was created.
     * @param  string|null  $revokedAt  The date and time the OAuth grant was revoked, or null if it is still active.
     * @param  string|null  $revokedReason  The reason the OAuth grant was revoked, or null if it is still active.
     * @param  array{name?: string, logo_uri?: string}|null  $client  The OAuth client the grant was issued to.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $clientId = null,
        public ?array $scopes = null,
        public ?string $createdAt = null,
        public ?string $revokedAt = null,
        public ?string $revokedReason = null,
        public ?array $client = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            clientId: $data['client_id'] ?? null,
            scopes: $data['scopes'] ?? null,
            createdAt: $data['created_at'] ?? null,
            revokedAt: $data['revoked_at'] ?? null,
            revokedReason: $data['revoked_reason'] ?? null,
            client: $data['client'] ?? null,
        );
    }
}
