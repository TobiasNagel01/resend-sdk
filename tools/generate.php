<?php

/**
 * Generates the Saloon requests, resources, DTOs, endpoint tests and the Boost skill's method
 * reference from the Resend OpenAPI spec.
 *
 * Usage: php tools/generate.php [--fetch]
 *
 *   --fetch  Download the latest spec into resources/openapi/resend.yaml first.
 */

declare(strict_types=1);

use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

require __DIR__.'/../vendor/autoload.php';

const SPEC_URL = 'https://raw.githubusercontent.com/resend/resend-openapi/refs/heads/main/resend.yaml';
const ROOT_NAMESPACE = 'TobiasNagel01\\ResendSdk';
const GENERATED_MARKER = '@generated';
const SKILL_REFERENCES = 'resources/boost/skills/resend-sdk-development/references';

$root = dirname(__DIR__);
$specPath = $root.'/resources/openapi/resend.yaml';

if (in_array('--fetch', $argv, true)) {
    $contents = file_get_contents(SPEC_URL);

    if ($contents === false) {
        fwrite(STDERR, 'Could not download the spec from '.SPEC_URL."\n");
        exit(1);
    }

    file_put_contents($specPath, $contents);
    echo "Downloaded spec to resources/openapi/resend.yaml\n";
}

$generator = new SdkGenerator(
    spec: Yaml::parseFile($specPath),
    overrides: require __DIR__.'/overrides.php',
    root: $root,
);

$generator->run();

final class SdkGenerator
{
    /** @var array<string, array<string, mixed>> */
    private array $schemas;

    /** @var array<string, array<string, mixed>> operationId => operation model */
    private array $operations = [];

    /** @var array<string, array<string, mixed>> DTO name => model */
    private array $dtos = [];

    /** @var array<string, string> component schema name => DTO name */
    private array $schemaDtos = [];

    /** @var array<string, array{dto: string, list: bool}> */
    private array $responseDtos = [];

    /** @var array<string, int> */
    private array $written = [];

    public function __construct(
        private readonly array $spec,
        private readonly array $overrides,
        private readonly string $root,
    ) {
        $this->schemas = $spec['components']['schemas'] ?? [];
    }

    public function run(): void
    {
        $this->collectOperations();
        $this->collectDtos();

        $this->clean(['src/Requests', 'src/Resources', 'src/Data', 'src/Concerns', 'tests/Generated']);

        // The skill references are read by AI agents, so they carry no marker; the directory is owned by the generator instead.
        array_map(unlink(...), glob("{$this->root}/".SKILL_REFERENCES.'/*.md') ?: []);

        foreach ($this->dtos as $dto) {
            $this->write("src/Data/{$dto['name']}.php", $this->renderDto($dto));
        }

        foreach ($this->operations as $operation) {
            $this->write("src/Requests/{$operation['resourceClass']}/{$operation['class']}.php", $this->renderRequest($operation));
        }

        foreach ($this->groupByResource() as $resource) {
            $this->write("src/Resources/{$resource['class']}.php", $this->renderResource($resource));
        }

        $this->write('src/Concerns/HasResources.php', $this->renderHasResources());
        $this->write('tests/Generated/EndpointsTest.php', $this->renderEndpointsTest());

        foreach ($this->groupByResource() as $resource) {
            $this->write(SKILL_REFERENCES.'/'.Str::kebab($resource['accessor']).'.md', $this->renderSkillReference($resource));
        }

        $this->write(SKILL_REFERENCES.'/data.md', $this->renderSkillDataReference());

        $this->format();

        printf(
            "Generated %d requests, %d resources, %d DTOs from Resend API %s.\n",
            count($this->operations),
            count($this->groupByResource()),
            count($this->dtos),
            $this->spec['info']['version'] ?? '?',
        );
    }

    // ---------------------------------------------------------------------
    // Model building
    // ---------------------------------------------------------------------

    private function collectOperations(): void
    {
        foreach ($this->spec['paths'] as $path => $item) {
            $sharedParameters = $item['parameters'] ?? [];

            foreach ($item as $httpMethod => $operation) {
                if (! in_array($httpMethod, ['get', 'post', 'put', 'patch', 'delete'], true)) {
                    continue;
                }

                $this->operations[$operation['operationId']] = $this->buildOperation(
                    $path,
                    strtoupper($httpMethod),
                    $operation,
                    [...$sharedParameters, ...($operation['parameters'] ?? [])],
                );
            }
        }
    }

    private function buildOperation(string $path, string $httpMethod, array $operation, array $parameters): array
    {
        $id = $operation['operationId'];
        [$resourceKey, $action] = explode('/', $id, 2);
        $resource = $this->resource($resourceKey);

        $model = [
            'id' => $id,
            'path' => $path,
            'httpMethod' => $httpMethod,
            'resourceKey' => $resourceKey,
            'resourceClass' => $resource['class'],
            'class' => ($this->overrides['requestNames'][$id] ?? $this->requestName($resource, $action)).'Request',
            'methodName' => $this->overrides['methodNames'][$id] ?? Str::camel($action),
            'summary' => $operation['summary'] ?? null,
            'description' => $operation['description'] ?? null,
            'deprecated' => (bool) ($operation['deprecated'] ?? false),
            'bodyType' => null,
            'params' => [],
        ];

        $params = [];

        foreach ($parameters as $parameter) {
            $parameter = $this->deref($parameter);
            $schema = $this->resolve($parameter['schema'] ?? []);

            $params[] = $this->param(
                key: $parameter['name'],
                in: $parameter['in'],
                schema: $schema,
                required: (bool) ($parameter['required'] ?? false),
                description: $parameter['description'] ?? ($schema['description'] ?? null),
            );
        }

        [$bodyType, $bodyParams] = $this->bodyParams($id, $operation);
        $model['bodyType'] = $bodyType;
        $params = [...$params, ...$bodyParams];

        // Path first, then required arguments, then optional ones; the original order is kept otherwise.
        $rank = fn (array $p): int => match (true) {
            $p['in'] === 'path' => 0,
            $p['required'] => 1,
            $p['in'] === 'body' => 2,
            $p['in'] === 'query' => 3,
            default => 4,
        };

        $indexed = array_map(null, array_keys($params), $params);
        usort($indexed, fn (array $a, array $b): int => [$rank($a[1]), $a[0]] <=> [$rank($b[1]), $b[0]]);
        $model['params'] = array_column($indexed, 1);

        $names = array_column($model['params'], 'name');

        if (count($names) !== count(array_unique($names))) {
            throw new RuntimeException("Duplicate argument names in {$id}: ".implode(', ', $names));
        }

        return $model;
    }

    /**
     * @return array{0: string|null, 1: list<array<string, mixed>>}
     */
    private function bodyParams(string $id, array $operation): array
    {
        $content = $operation['requestBody']['content'] ?? null;
        $schema = $this->overrides['requestBodies'][$id] ?? null;
        $contentType = $schema !== null ? 'application/json' : null;

        if ($schema === null && $content !== null) {
            $contentType = array_key_first($content);
            $schema = $content[$contentType]['schema'] ?? [];
        }

        if ($schema === null) {
            return [null, []];
        }

        $schema = $this->resolve($schema);
        $bodyRequired = (bool) ($operation['requestBody']['required'] ?? false);

        if (($schema['type'] ?? null) === 'array') {
            $itemName = Str::camel(Str::before($id, '/'));

            return ['json-array', [$this->param(
                key: $itemName,
                in: 'body',
                schema: $schema,
                required: true,
                description: $schema['description'] ?? 'The items to send.',
            )]];
        }

        $type = $contentType === 'multipart/form-data' ? 'multipart' : 'json';
        $required = $schema['required'] ?? [];
        $jsonFields = $this->overrides['jsonFields'][$id] ?? [];
        $params = [];

        foreach ($schema['properties'] ?? [] as $key => $property) {
            $property = $this->resolve($property);
            $param = $this->param(
                key: $key,
                in: 'body',
                schema: $property,
                required: in_array($key, $required, true),
                description: $property['description'] ?? null,
            );

            if ($type === 'multipart' && ($property['format'] ?? null) === 'binary') {
                $param['binary'] = true;
                $param['type'] = 'mixed';
                $param['doc'] = 'resource|\\Psr\\Http\\Message\\StreamInterface|string';
                $param['nullable'] = false;
            }

            if (in_array($key, $jsonFields, true)) {
                $param['json'] = true;
                $param['type'] = 'array|string';
                $param['doc'] = 'array<mixed>|string';
            }

            $params[] = $param;
        }

        foreach ($params as $param) {
            if ($param['binary'] ?? false) {
                $params[] = [
                    'name' => $param['name'].'Name',
                    'key' => $param['key'],
                    'in' => 'filename',
                    'type' => 'string',
                    'doc' => 'string',
                    'nullable' => false,
                    'required' => false,
                    'omit' => false,
                    'default' => var_export($this->overrides['uploadFilenames'][$id] ?? $param['key'], true),
                    'description' => "Filename sent with the `{$param['key']}` upload.",
                ];
            }
        }

        if (! $bodyRequired && $required === [] && $params === []) {
            return [null, []];
        }

        return [$type, $params];
    }

    private function param(string $key, string $in, array $schema, bool $required, ?string $description): array
    {
        $nullable = $this->isNullable($schema);
        $name = Str::camel(str_replace('-', '_', $key));

        if ($in !== 'path') {
            $name = $this->overrides['reservedProperties'][$name] ?? $name;
        }

        $param = [
            'name' => $name,
            'key' => $key,
            'in' => $in,
            'type' => $this->phpType($schema),
            'doc' => $this->docType($schema),
            'nullable' => $nullable,
            'required' => $required,
            // Optional nullable body fields need a sentinel so an explicit null can still be sent.
            'omit' => ! $required && $nullable && $in === 'body',
            'description' => $description,
        ];

        $param['default'] = $param['required'] ? null : ($param['omit'] ? 'Omit::Value' : 'null');

        return $param;
    }

    private function collectDtos(): void
    {
        foreach ($this->overrides['dtos'] as $name => $sources) {
            foreach ($sources as $source) {
                if (str_starts_with($source, 'schema:')) {
                    $this->schemaDtos[substr($source, 7)] = $name;
                }
            }
        }

        foreach ($this->overrides['dtos'] as $name => $sources) {
            $properties = [];
            $requiredSets = [];

            foreach ($sources as $source) {
                if (str_starts_with($source, 'schema:')) {
                    $schema = $this->resolve($this->schemas[substr($source, 7)] ?? throw new RuntimeException("Unknown schema {$source}"));
                } else {
                    [$schema, $isList] = $this->responseSchema($source);
                    $this->responseDtos[$source] = ['dto' => $name, 'list' => $isList];
                }

                $requiredSets[] = $schema['required'] ?? [];

                foreach ($schema['properties'] ?? [] as $key => $property) {
                    $properties[$key] ??= $property;
                }
            }

            $required = array_values(array_intersect(...$requiredSets) ?: []);
            $props = [];

            foreach ($properties as $key => $property) {
                $nested = $this->nestedDto($property);
                $resolved = $this->resolve($property);
                $isRequired = in_array($key, $required, true) && count($requiredSets) === count(array_filter($requiredSets, fn ($set) => in_array($key, $set, true)));

                $props[] = [
                    'name' => Str::camel($key),
                    'key' => $key,
                    'type' => $nested ? ($nested['list'] ? 'array' : $nested['dto']) : $this->phpType($resolved),
                    'doc' => $nested ? ($nested['list'] ? "list<{$nested['dto']}>" : $nested['dto']) : $this->docType($resolved),
                    'nested' => $nested,
                    'nullable' => ! $isRequired || $this->isNullable($resolved),
                    'required' => $isRequired,
                    'description' => $resolved['description'] ?? null,
                ];
            }

            usort($props, fn (array $a, array $b): int => $b['required'] <=> $a['required']);

            $this->dtos[$name] = ['name' => $name, 'sources' => $sources, 'properties' => $props];
        }
    }

    /**
     * @return array{0: array<string, mixed>, 1: bool} the (item) schema and whether the response is a list
     */
    private function responseSchema(string $operationId): array
    {
        $operation = $this->findOperation($operationId);

        foreach ($operation['responses'] ?? [] as $status => $response) {
            if (str_starts_with((string) $status, '2')) {
                $schema = $this->resolve($response['content']['application/json']['schema'] ?? []);

                if (isset($schema['properties']['data']['items']) && ($schema['properties']['data']['type'] ?? null) === 'array') {
                    return [$this->resolve($schema['properties']['data']['items']), true];
                }

                return [$schema, false];
            }
        }

        throw new RuntimeException("No success response for {$operationId}");
    }

    private function findOperation(string $operationId): array
    {
        foreach ($this->spec['paths'] as $item) {
            foreach ($item as $operation) {
                if (is_array($operation) && ($operation['operationId'] ?? null) === $operationId) {
                    return $operation;
                }
            }
        }

        throw new RuntimeException("Unknown operation {$operationId}");
    }

    /**
     * @return array{dto: string, list: bool}|null
     */
    private function nestedDto(array $property): ?array
    {
        $ref = $property['$ref'] ?? ($property['allOf'][0]['$ref'] ?? null);

        if ($ref !== null && isset($this->schemaDtos[$this->refName($ref)])) {
            return ['dto' => $this->schemaDtos[$this->refName($ref)], 'list' => false];
        }

        $itemRef = $property['items']['$ref'] ?? null;

        if (($property['type'] ?? null) === 'array' && $itemRef !== null && isset($this->schemaDtos[$this->refName($itemRef)])) {
            return ['dto' => $this->schemaDtos[$this->refName($itemRef)], 'list' => true];
        }

        return null;
    }

    private function groupByResource(): array
    {
        $resources = [];

        foreach ($this->operations as $operation) {
            $key = $operation['resourceKey'];
            $resources[$key] ??= [...$this->resource($key), 'operations' => []];
            $resources[$key]['operations'][] = $operation;
        }

        return $resources;
    }

    private function resource(string $key): array
    {
        $class = Str::studly($key);

        return [
            'key' => $key,
            'class' => $this->overrides['resources'][$key]['class'] ?? $class,
            'accessor' => $this->overrides['resources'][$key]['accessor'] ?? Str::camel($key),
            'singular' => $this->overrides['resources'][$key]['singular'] ?? Str::singular($class),
        ];
    }

    private function requestName(array $resource, string $action): string
    {
        $words = explode('-', $action);
        $verb = Str::studly(array_shift($words));

        if ($words === []) {
            return $verb.($verb === 'List' ? $resource['class'] : $resource['singular']);
        }

        return $verb.$resource['singular'].Str::studly(implode('-', $words));
    }

    // ---------------------------------------------------------------------
    // Schema helpers
    // ---------------------------------------------------------------------

    private function refName(string $ref): string
    {
        return Str::afterLast($ref, '/');
    }

    private function deref(array $node): array
    {
        if (! isset($node['$ref'])) {
            return $node;
        }

        $path = explode('/', ltrim(Str::after($node['$ref'], '#'), '/'));
        $target = $this->spec;

        foreach ($path as $segment) {
            $target = $target[$segment] ?? throw new RuntimeException("Unresolvable \$ref {$node['$ref']}");
        }

        return $this->deref($target);
    }

    /**
     * Follow $ref and flatten allOf into a single schema.
     */
    private function resolve(array $schema): array
    {
        if (isset($schema['$ref'])) {
            $description = $schema['description'] ?? null;
            $schema = $this->resolve($this->deref($schema));

            if ($description !== null) {
                $schema['description'] = $description;
            }
        }

        if (isset($schema['allOf'])) {
            $merged = array_diff_key($schema, ['allOf' => true]);

            foreach ($schema['allOf'] as $part) {
                $part = $this->resolve($part);
                $merged['properties'] = [...($merged['properties'] ?? []), ...($part['properties'] ?? [])];
                $merged['required'] = [...($merged['required'] ?? []), ...($part['required'] ?? [])];
                $merged += $part;
            }

            if ($merged['properties'] === []) {
                unset($merged['properties']);
            }

            $schema = $merged;
        }

        return $schema;
    }

    /**
     * @return list<string> JSON schema types, e.g. ['string', 'null']
     */
    private function types(array $schema): array
    {
        $schema = $this->resolve($schema);

        foreach (['oneOf', 'anyOf'] as $keyword) {
            if (isset($schema[$keyword])) {
                return array_values(array_unique(array_merge(...array_map(fn (array $s) => $this->types($s), $schema[$keyword]))));
            }
        }

        $types = (array) ($schema['type'] ?? []);

        if ($types === [] && isset($schema['properties'])) {
            $types = ['object'];
        }

        if (($schema['nullable'] ?? false) === true) {
            $types[] = 'null';
        }

        return $types;
    }

    private function isNullable(array $schema): bool
    {
        return in_array('null', $this->types($schema), true);
    }

    private function phpType(array $schema): string
    {
        $map = [
            'string' => 'string',
            'integer' => 'int',
            'number' => 'int|float',
            'boolean' => 'bool',
            'array' => 'array',
            'object' => 'array',
        ];

        $types = array_diff($this->types($schema), ['null']);

        if ($types === []) {
            return 'mixed';
        }

        $php = [];

        foreach ($types as $type) {
            foreach (explode('|', $map[$type] ?? 'mixed') as $t) {
                $php[$t] = true;
            }
        }

        return isset($php['mixed']) ? 'mixed' : implode('|', array_keys($php));
    }

    private function docType(array $schema, int $depth = 0): string
    {
        $schema = $this->resolve($schema);

        foreach (['oneOf', 'anyOf'] as $keyword) {
            if (isset($schema[$keyword])) {
                $parts = array_map(fn (array $s) => $this->docType($s, $depth), array_filter($schema[$keyword], fn ($s) => $this->types($s) !== ['null']));

                return implode('|', array_unique($parts));
            }
        }

        $types = array_values(array_diff($this->types($schema), ['null']));

        if (count($types) > 1) {
            return implode('|', array_map(fn (string $t) => $this->docType([...$schema, 'type' => $t, 'nullable' => false], $depth), $types));
        }

        $type = $types[0] ?? null;

        if (isset($schema['enum']) && $type === 'string') {
            $values = array_filter($schema['enum'], fn ($v) => is_string($v) && $v !== '');

            return implode('|', array_map(fn (string $v) => "'".addslashes($v)."'", $values));
        }

        return match ($type) {
            'string' => 'string',
            'integer' => 'int',
            'number' => 'int|float',
            'boolean' => 'bool',
            'array' => 'list<'.(isset($schema['items']) ? $this->docType($schema['items'], $depth) : 'mixed').'>',
            'object' => $this->objectDoc($schema, $depth),
            default => 'mixed',
        };
    }

    private function objectDoc(array $schema, int $depth): string
    {
        if (! isset($schema['properties']) || $depth >= 2) {
            return 'array<string, mixed>';
        }

        $required = $schema['required'] ?? [];
        $fields = [];

        foreach ($schema['properties'] as $key => $property) {
            $fields[] = $key.(in_array($key, $required, true) ? '' : '?').': '.$this->docType($property, $depth + 1);
        }

        return 'array{'.implode(', ', $fields).'}';
    }

    // ---------------------------------------------------------------------
    // Rendering
    // ---------------------------------------------------------------------

    private function renderRequest(array $op): string
    {
        $namespace = ROOT_NAMESPACE."\\Requests\\{$op['resourceClass']}";
        $uses = ['Saloon\\Enums\\Method', 'Saloon\\Http\\Request'];
        $implements = '';
        $traits = '';
        $methods = [];

        if ($op['bodyType'] !== null) {
            $uses[] = 'Saloon\\Contracts\\Body\\HasBody';
            $implements = ' implements HasBody';
            $trait = $op['bodyType'] === 'multipart' ? 'HasMultipartBody' : 'HasJsonBody';
            $uses[] = "Saloon\\Traits\\Body\\{$trait}";
            $traits = "    use {$trait};\n\n";
        }

        $params = $op['params'];

        if (array_filter($params, fn ($p) => $p['omit'])) {
            $uses[] = ROOT_NAMESPACE.'\\Support\\Omit';
        }

        $methods[] = $this->renderEndpoint($op);

        $body = array_values(array_filter($params, fn ($p) => $p['in'] === 'body'));

        if ($op['bodyType'] !== null) {
            $uses[] = ROOT_NAMESPACE.'\\Support\\Payload';
            $methods[] = $this->renderBody($op, $body, $params);
        }

        $query = array_values(array_filter($params, fn ($p) => $p['in'] === 'query'));

        if ($query !== []) {
            $uses[] = ROOT_NAMESPACE.'\\Support\\Payload';
            $lines = array_map(fn ($p) => "            '{$p['key']}' => \$this->{$p['name']},", $query);
            $methods[] = "    protected function defaultQuery(): array\n    {\n        return Payload::query([\n".implode("\n", $lines)."\n        ]);\n    }";
        }

        $headers = array_values(array_filter($params, fn ($p) => $p['in'] === 'header'));

        if ($headers !== []) {
            $uses[] = ROOT_NAMESPACE.'\\Support\\Payload';
            $lines = array_map(fn ($p) => "            '{$p['key']}' => \$this->{$p['name']},", $headers);
            $methods[] = "    protected function defaultHeaders(): array\n    {\n        return Payload::headers([\n".implode("\n", $lines)."\n        ]);\n    }";
        }

        if ($dto = $this->responseDtos[$op['id']] ?? null) {
            $uses[] = 'Saloon\\Http\\Response';
            $uses[] = ROOT_NAMESPACE."\\Data\\{$dto['dto']}";

            if ($dto['list']) {
                $uses[] = ROOT_NAMESPACE.'\\Data\\ListResponse';
                $methods[] = "    /**\n     * @return ListResponse<{$dto['dto']}>\n     */\n    public function createDtoFromResponse(Response \$response): ListResponse\n    {\n        return ListResponse::fromArray(\$response->json(), {$dto['dto']}::fromArray(...));\n    }";
            } else {
                $methods[] = "    public function createDtoFromResponse(Response \$response): {$dto['dto']}\n    {\n        return {$dto['dto']}::fromArray(\$response->json());\n    }";
            }
        }

        $constructor = $params === []
            ? ''
            : $this->renderParamDocs($params, '    ')
                ."    public function __construct(\n"
                .implode("\n", array_map(fn ($p) => '        public readonly '.$this->renderParam($p).',', $params))
                ."\n    ) {}\n\n";

        $classDoc = $this->classDoc($op);

        return $this->phpFile($namespace, $uses, <<<PHP
            {$classDoc}
            class {$op['class']} extends Request{$implements}
            {
            {$traits}    protected Method \$method = Method::{$op['httpMethod']};

            {$constructor}
            PHP
            .implode("\n\n", $methods)."\n}\n");
    }

    private function renderEndpoint(array $op): string
    {
        $parts = preg_split('/(\{[^}]+\})/', $op['path'], -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $byKey = array_column(array_filter($op['params'], fn ($p) => $p['in'] === 'path'), 'name', 'key');
        $segments = [];

        foreach ($parts as $part) {
            if (preg_match('/^\{(.+)\}$/', $part, $m)) {
                $name = $byKey[$m[1]] ?? throw new RuntimeException("Missing path parameter {$m[1]} in {$op['id']}");
                $segments[] = "rawurlencode(\$this->{$name})";
            } else {
                $segments[] = var_export($part, true);
            }
        }

        return "    public function resolveEndpoint(): string\n    {\n        return ".implode('.', $segments).";\n    }";
    }

    private function renderBody(array $op, array $body, array $params): string
    {
        if ($op['bodyType'] === 'json-array') {
            return "    protected function defaultBody(): array\n    {\n        return \$this->{$body[0]['name']};\n    }";
        }

        if ($op['bodyType'] === 'multipart') {
            $files = [];
            $fields = [];

            foreach ($body as $p) {
                if ($p['binary'] ?? false) {
                    $filename = array_values(array_filter($params, fn ($f) => $f['in'] === 'filename' && $f['key'] === $p['key']))[0]['name'];
                    $files[] = "            '{$p['key']}' => [\$this->{$p['name']}, \$this->{$filename}],";
                } else {
                    $value = ($p['json'] ?? false) ? "Payload::json(\$this->{$p['name']})" : "\$this->{$p['name']}";
                    $fields[] = "            '{$p['key']}' => {$value},";
                }
            }

            return "    protected function defaultBody(): array\n    {\n        return Payload::multipart(\n            fields: [\n"
                .implode("\n", array_map(fn ($l) => '    '.$l, $fields))
                ."\n            ],\n            files: [\n"
                .implode("\n", array_map(fn ($l) => '    '.$l, $files))
                ."\n            ],\n        );\n    }";
        }

        $lines = array_map(fn ($p) => "            '{$p['key']}' => \$this->{$p['name']},", $body);
        $nullable = array_values(array_map(fn ($p) => var_export($p['key'], true), array_filter($body, fn ($p) => $p['nullable'])));
        $nullableArg = $nullable === [] ? '' : ', nullable: ['.implode(', ', $nullable).']';
        $array = $body === [] ? '[]' : "[\n".implode("\n", $lines)."\n        ]";

        return "    protected function defaultBody(): array\n    {\n        return Payload::body({$array}{$nullableArg});\n    }";
    }

    private function renderParam(array $p): string
    {
        $type = $p['type'];

        if ($p['omit']) {
            $type = $type === 'mixed' ? 'mixed' : $type.'|Omit|null';
        } elseif ($this->acceptsNull($p)) {
            $type = $this->nullableType($type);
        }

        return "{$type} \${$p['name']}".($p['default'] !== null ? " = {$p['default']}" : '');
    }

    private function acceptsNull(array $p): bool
    {
        return $p['nullable'] || (! $p['required'] && $p['default'] === 'null');
    }

    private function nullableType(string $type): string
    {
        return match (true) {
            $type === 'mixed' => 'mixed',
            str_contains($type, '|') => $type.'|null',
            default => '?'.$type,
        };
    }

    private function renderParamDocs(array $params, string $indent): string
    {
        return $this->docBlock($this->paramDocLines($params), $indent);
    }

    /**
     * @return list<string>
     */
    private function paramDocLines(array $params): array
    {
        $lines = [];

        foreach ($params as $p) {
            $description = $this->oneLine($p['description']);
            $lines[] = rtrim("@param  {$this->paramDocType($p)}  \${$p['name']}  {$description}");
        }

        return $lines;
    }

    private function paramDocType(array $p): string
    {
        $doc = $p['doc'];

        if ($p['type'] === 'mixed' && $doc === 'mixed') {
            return 'mixed';
        }

        if ($p['omit']) {
            return $doc.'|null|Omit';
        }

        if ($this->acceptsNull($p)) {
            return $doc.(str_contains($doc, 'null') ? '' : '|null');
        }

        return $doc;
    }

    private function renderResource(array $resource): string
    {
        $namespace = ROOT_NAMESPACE.'\\Resources';
        $uses = ['Saloon\\Http\\BaseResource', 'Saloon\\Http\\Response'];
        $methods = [];

        foreach ($resource['operations'] as $op) {
            $uses[] = ROOT_NAMESPACE."\\Requests\\{$op['resourceClass']}\\{$op['class']}";

            if (array_filter($op['params'], fn ($p) => $p['omit'])) {
                $uses[] = ROOT_NAMESPACE.'\\Support\\Omit';
            }

            $docLines = [$this->oneLine($op['summary'])];
            $dto = $this->responseDtos[$op['id']] ?? null;

            if ($dto !== null) {
                $docLines[] = '';
                $docLines[] = '`$response->dto()` returns '.($dto['list'] ? "a ListResponse<{$dto['dto']}>." : $this->article($dto['dto'])." {$dto['dto']}.");
            }

            if ($op['deprecated']) {
                $docLines[] = '';
                $docLines[] = '@deprecated';
            }

            if ($op['params'] !== []) {
                $docLines[] = '';
                array_push($docLines, ...$this->paramDocLines($op['params']));
            }

            $signature = array_map(fn ($p) => $this->renderParam($p), $op['params']);
            $arguments = array_map(fn ($p) => "\${$p['name']}", $op['params']);

            if (count($signature) > 3) {
                $signature = "\n        ".implode(",\n        ", $signature).",\n    ";
                $arguments = "\n            ".implode(",\n            ", $arguments).",\n        ";
            } else {
                $signature = implode(', ', $signature);
                $arguments = implode(', ', $arguments);
            }

            $methods[] = $this->docBlock($docLines, '    ')
                ."    public function {$op['methodName']}({$signature}): Response\n    {\n"
                ."        return \$this->connector->send(new {$op['class']}({$arguments}));\n    }";
        }

        $title = $resource['class'];

        return $this->phpFile($namespace, $uses, <<<PHP
            /**
             * {$title} endpoints of the Resend API.
             *
             * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
             */
            class {$resource['class']} extends BaseResource
            {

            PHP
            .implode("\n\n", $methods)."\n}\n");
    }

    private function renderHasResources(): string
    {
        $uses = [];
        $methods = [];

        foreach ($this->groupByResource() as $resource) {
            $uses[] = ROOT_NAMESPACE."\\Resources\\{$resource['class']}";
            $methods[] = "    public function {$resource['accessor']}(): {$resource['class']}\n    {\n        return new {$resource['class']}(\$this);\n    }";
        }

        return $this->phpFile(ROOT_NAMESPACE.'\\Concerns', $uses, <<<'PHP'
            /**
             * Resource accessors of the Resend connector.
             *
             * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
             */
            trait HasResources
            {

            PHP
            .implode("\n\n", $methods)."\n}\n", 'trait');
    }

    private function renderDto(array $dto): string
    {
        $uses = [];
        $docs = [];
        $args = [];
        $mapping = [];

        foreach ($dto['properties'] as $p) {
            $type = $p['nullable'] ? $this->nullableType($p['type']) : $p['type'];
            $doc = $p['doc'];

            if ($p['nullable'] && ! str_contains($doc, 'null') && $doc !== 'mixed') {
                $doc .= '|null';
            }

            $docs[] = rtrim("@param  {$doc}  \${$p['name']}  ".$this->oneLine($p['description']));
            $args[] = "        public {$type} \${$p['name']}".($p['required'] ? '' : ' = null').',';

            $value = "\$data['{$p['key']}']".($p['required'] ? '' : ' ?? null');

            if ($p['nested'] !== null) {
                $class = $p['nested']['dto'];
                $value = $p['nested']['list']
                    ? "isset(\$data['{$p['key']}']) ? array_map({$class}::fromArray(...), \$data['{$p['key']}']) : null"
                    : "isset(\$data['{$p['key']}']) ? {$class}::fromArray(\$data['{$p['key']}']) : null";
            }

            $mapping[] = "            {$p['name']}: {$value},";
        }

        $sources = implode(', ', $dto['sources']);
        $paramDocs = $this->docBlock($docs, '    ');

        return $this->phpFile(ROOT_NAMESPACE.'\\Data', $uses, <<<PHP
            /**
             * @generated from the Resend OpenAPI spec ({$sources}). Do not edit by hand, run `composer generate` instead.
             */
            final readonly class {$dto['name']}
            {
            {$paramDocs}    public function __construct(
            PHP
            ."\n".implode("\n", $args)."\n    ) {}\n\n"
            ."    /**\n     * @param  array<string, mixed>  \$data\n     */\n"
            ."    public static function fromArray(array \$data): self\n    {\n        return new self(\n"
            .implode("\n", $mapping)
            ."\n        );\n    }\n}\n", 'class');
    }

    private function renderEndpointsTest(): string
    {
        $cases = [];

        foreach ($this->operations as $op) {
            $required = array_filter($op['params'], fn ($p) => $p['required']);
            $arguments = implode(', ', array_map(fn ($p) => $this->dummy($p), $required));
            $path = preg_replace_callback('/\{([^}]+)\}/', fn ($m) => "test-{$m[1]}", $op['path']);
            $closure = "fn (Resend \$resend) => \$resend->{$this->resource($op['resourceKey'])['accessor']}()->{$op['methodName']}({$arguments})";

            $cases[] = "    '{$op['id']}' => [{$closure}, '{$op['httpMethod']}', '{$path}'],";
        }

        $cases = implode("\n", $cases);

        return <<<PHP
            <?php

            /**
             * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
             */

            use Saloon\\Http\\Faking\\MockClient;
            use Saloon\\Http\\Faking\\MockResponse;
            use TobiasNagel01\\ResendSdk\\Resend;

            it('sends every operation to the documented endpoint', function (Closure \$call, string \$method, string \$path) {
                \$mockClient = new MockClient([MockResponse::make(['object' => 'list', 'data' => []])]);
                \$resend = (new Resend('re_test'))->withMockClient(\$mockClient);

                \$response = \$call(\$resend);

                expect(\$response->getPendingRequest()->getMethod()->value)->toBe(\$method)
                    ->and(\$response->getPsrRequest()->getUri()->getPath())->toBe(\$path);
            })->with([
            {$cases}
            ]);

            PHP;
    }

    private function renderSkillReference(array $resource): string
    {
        $accessor = "Resend::{$resource['accessor']}()";
        $sections = [];

        foreach ($resource['operations'] as $op) {
            $lines = ["## `{$op['methodName']}()`", ''];
            $lines[] = rtrim("`{$op['httpMethod']} {$op['path']}` – {$this->markdownLine($op['summary'])}");

            if ($op['deprecated']) {
                $lines[] = '';
                $lines[] = '**Deprecated.**';
            }

            if ($op['description'] !== null && $this->markdownLine($op['description']) !== $this->markdownLine($op['summary'])) {
                $lines[] = '';
                $lines[] = $this->markdownLine($op['description']);
            }

            $signature = array_map(fn ($p) => $this->renderParam($p), $op['params']);
            $signature = count($signature) > 3
                ? "\n    ".implode(",\n    ", $signature).",\n"
                : implode(', ', $signature);

            array_push($lines, '', '```php', "{$accessor}->{$op['methodName']}({$signature}): Response", '```');

            $dto = $this->responseDtos[$op['id']] ?? null;

            if ($dto !== null) {
                $lines[] = '';
                $lines[] = $dto['list']
                    ? "`\$response->dto()` returns a `ListResponse` of `{$dto['dto']}`."
                    : "`\$response->dto()` returns {$this->article($dto['dto'])} `{$dto['dto']}`.";
            }

            if ($op['params'] !== []) {
                $lines[] = '';

                foreach ($op['params'] as $p) {
                    $flags = array_filter([
                        "`{$this->paramDocType($p)}`",
                        $p['required'] ? 'required' : null,
                        $p['in'] === 'body' ? null : "{$p['in']} `{$p['key']}`",
                        $p['in'] === 'body' && $p['key'] !== $p['name'] ? "field `{$p['key']}`" : null,
                    ]);

                    $lines[] = rtrim("- `\${$p['name']}` (".implode(', ', $flags).') '.$this->markdownLine($p['description']));
                }
            }

            $sections[] = implode("\n", $lines);
        }

        return "# {$accessor}\n\n"
            ."{$resource['class']} endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\\Http\\Response`; "
            .'failed requests throw `TobiasNagel01\\ResendSdk\\Exceptions\\ResendException`. '
            ."The matching Saloon request classes live in `TobiasNagel01\\ResendSdk\\Requests\\{$resource['class']}`.\n\n"
            .implode("\n\n", $sections)."\n";
    }

    private function renderSkillDataReference(): string
    {
        $sections = [];

        foreach ($this->dtos as $dto) {
            $lines = ["## `{$dto['name']}`", ''];

            foreach ($dto['properties'] as $p) {
                $doc = $p['doc'];

                if ($p['nullable'] && ! str_contains($doc, 'null') && $doc !== 'mixed') {
                    $doc .= '|null';
                }

                $lines[] = rtrim("- `\${$p['name']}` (`{$doc}`, key `{$p['key']}`) ".$this->markdownLine($p['description']));
            }

            $sections[] = implode("\n", $lines);
        }

        return "# DTOs\n\n"
            .'Readonly classes in `TobiasNagel01\\ResendSdk\\Data`, returned by `$response->dto()`. '
            .'List endpoints return a `TobiasNagel01\\ResendSdk\\Data\\ListResponse` with `data` (list of DTOs), `hasMore` and `nextCursor()`. '
            ."Every DTO can also be built from a raw API payload with `::fromArray(array \$data)`.\n\n"
            .implode("\n\n", $sections)."\n";
    }

    private function markdownLine(?string $text): string
    {
        return $text === null ? '' : preg_replace('/\s+/', ' ', trim($text));
    }

    private function dummy(array $p): string
    {
        if ($p['in'] === 'path') {
            return var_export("test-{$p['key']}", true);
        }

        return match (explode('|', $p['type'])[0]) {
            'int' => '1',
            'bool' => 'true',
            'array' => '[]',
            default => "'test'",
        };
    }

    // ---------------------------------------------------------------------
    // Output helpers
    // ---------------------------------------------------------------------

    private function classDoc(array $op): string
    {
        $lines = [];

        if ($summary = $this->oneLine($op['summary'])) {
            $lines[] = $summary;
        }

        if ($description = $this->oneLine($op['description'])) {
            $lines[] = '';
            $lines[] = $description;
        }

        if ($op['deprecated']) {
            $lines[] = '';
            $lines[] = '@deprecated';
        }

        $lines[] = '';
        $lines[] = "{$op['httpMethod']} {$op['path']}";
        $lines[] = '';
        $lines[] = "@generated from the Resend OpenAPI spec ({$op['id']}). Do not edit by hand, run `composer generate` instead.";

        return rtrim($this->docBlock($lines, ''));
    }

    private function article(string $word): string
    {
        return in_array(strtolower($word[0]), ['a', 'e', 'i', 'o', 'u'], true) ? 'an' : 'a';
    }

    private function docBlock(array $lines, string $indent): string
    {
        if ($lines === []) {
            return '';
        }

        $body = implode("\n", array_map(fn ($l) => rtrim("{$indent} * {$l}"), $lines));

        return "{$indent}/**\n{$body}\n{$indent} */\n";
    }

    private function oneLine(?string $text): string
    {
        if ($text === null) {
            return '';
        }

        $text = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '$1: $2', $text);
        $text = preg_replace('/\s+/', ' ', trim($text));

        return str_replace('*/', '*\\/', $text);
    }

    private function phpFile(string $namespace, array $uses, string $body, string $kind = 'class'): string
    {
        $uses = array_unique($uses);
        sort($uses);
        $useLines = $uses === [] ? '' : implode("\n", array_map(fn ($u) => "use {$u};", $uses))."\n\n";

        return "<?php\n\ndeclare(strict_types=1);\n\nnamespace {$namespace};\n\n{$useLines}{$body}";
    }

    private function clean(array $directories): void
    {
        foreach ($directories as $directory) {
            $path = "{$this->root}/{$directory}";

            if (! is_dir($path)) {
                continue;
            }

            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);

            foreach ($files as $file) {
                if ($file->isFile() && str_contains((string) file_get_contents($file->getPathname()), GENERATED_MARKER)) {
                    unlink($file->getPathname());
                } elseif ($file->isDir() && count(scandir($file->getPathname())) === 2) {
                    rmdir($file->getPathname());
                }
            }
        }
    }

    private function write(string $relativePath, string $contents): void
    {
        $path = "{$this->root}/{$relativePath}";

        if (isset($this->written[$relativePath])) {
            throw new RuntimeException("File generated twice: {$relativePath}");
        }

        if (! is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        file_put_contents($path, $contents);
        $this->written[$relativePath] = 1;
    }

    private function format(): void
    {
        $pint = "{$this->root}/vendor/bin/pint";

        if (! is_file($pint)) {
            echo "Pint not installed, skipping formatting.\n";

            return;
        }

        $paths = implode(' ', array_map('escapeshellarg', ["{$this->root}/src", "{$this->root}/tests/Generated"]));
        exec('cd '.escapeshellarg($this->root).' && '.escapeshellarg(PHP_BINARY).' '.escapeshellarg($pint).' --quiet '.$paths, $output, $exitCode);

        if ($exitCode !== 0) {
            throw new RuntimeException("Pint failed:\n".implode("\n", $output));
        }
    }
}
