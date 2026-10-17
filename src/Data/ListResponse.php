<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * A list response ({"object": "list", "has_more": bool, "data": [...]}) with mapped items.
 *
 * @template TItem
 *
 * @implements IteratorAggregate<int, TItem>
 */
final readonly class ListResponse implements Countable, IteratorAggregate
{
    /**
     * @param  list<TItem>  $data
     */
    public function __construct(
        public array $data,
        public bool $hasMore = false,
    ) {}

    /**
     * @template T
     *
     * @param  array<string, mixed>  $payload
     * @param  callable(array<string, mixed>): T  $map
     * @return self<T>
     */
    public static function fromArray(array $payload, callable $map): self
    {
        return new self(
            data: array_values(array_map($map, $payload['data'] ?? [])),
            hasMore: (bool) ($payload['has_more'] ?? false),
        );
    }

    /**
     * The cursor to pass as `after` to fetch the next page.
     */
    public function nextCursor(): ?string
    {
        if (! $this->hasMore || $this->data === []) {
            return null;
        }

        $last = $this->data[array_key_last($this->data)];

        return is_object($last) && property_exists($last, 'id') ? $last->id : ($last['id'] ?? null);
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }
}
