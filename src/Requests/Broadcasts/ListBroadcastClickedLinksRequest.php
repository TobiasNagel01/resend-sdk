<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Broadcasts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a broadcast's clicked links
 *
 * GET /broadcasts/{id}/clicked-links
 *
 * @generated from the Resend OpenAPI spec (broadcasts/list-clicked-links). Do not edit by hand, run `composer generate` instead.
 */
class ListBroadcastClickedLinksRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $id  The Broadcast ID.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function __construct(
        public readonly string $id,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/broadcasts/'.rawurlencode($this->id).'/clicked-links';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'limit' => $this->limit,
            'after' => $this->after,
            'before' => $this->before,
        ]);
    }
}
