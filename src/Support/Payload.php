<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Support;

use Saloon\Data\MultipartValue;

/**
 * Builds request payloads from the arguments of the generated requests.
 */
final class Payload
{
    /**
     * Drop omitted fields; `null` is only kept for keys the API accepts as nullable.
     *
     * @param  array<string, mixed>  $data
     * @param  list<string>  $nullable
     * @return array<string, mixed>
     */
    public static function body(array $data, array $nullable = []): array
    {
        return array_filter(
            $data,
            fn (mixed $value, string $key): bool => $value !== Omit::Value && ($value !== null || in_array($key, $nullable, true)),
            ARRAY_FILTER_USE_BOTH,
        );
    }

    /**
     * Drop empty values, send booleans as `true`/`false` and arrays comma-separated (`style: form, explode: false`).
     *
     * @param  array<string, mixed>  $data
     * @return array<string, string|int|float>
     */
    public static function query(array $data): array
    {
        $query = [];

        foreach ($data as $key => $value) {
            $query[$key] = match (true) {
                $value === null, $value === Omit::Value => null,
                is_bool($value) => $value ? 'true' : 'false',
                is_array($value) => implode(',', $value),
                default => $value,
            };
        }

        return array_filter($query, fn (mixed $value): bool => $value !== null);
    }

    /**
     * @param  array<string, string|null>  $data
     * @return array<string, string>
     */
    public static function headers(array $data): array
    {
        return array_filter($data, fn (?string $value): bool => $value !== null);
    }

    /**
     * Encode arrays for multipart fields that expect a JSON string.
     */
    public static function json(mixed $value): mixed
    {
        return is_array($value) ? json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES) : $value;
    }

    /**
     * @param  array<string, mixed>  $fields
     * @param  array<string, array{0: mixed, 1: string|null}>  $files  name => [contents, filename]
     * @return list<MultipartValue>
     */
    public static function multipart(array $fields, array $files = []): array
    {
        $parts = [];

        foreach ($files as $name => [$contents, $filename]) {
            $parts[] = new MultipartValue($name, $contents, $filename);
        }

        foreach (self::body($fields) as $name => $value) {
            $parts[] = new MultipartValue($name, is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $parts;
    }
}
