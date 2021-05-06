<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordHandler;

final class JsonObject implements JsonValue
{
    /**
     * @var array<string, JsonValue>
     * @readonly
     */
    private $properties;

    /**
     * @var JsonPointer
     * @readonly
     */
    private $path;

    /**
     * @param array<string, JsonValue> $properties
     * @param JsonPointer $path
     */
    public function __construct(array $properties, JsonPointer $path)
    {
        $this->properties = $properties;
        $this->path = $path;
    }

    /**
     * @return array<string, JsonValue>
     * @psalm-mutation-free
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @return JsonPointer
     * @psalm-mutation-free
     */
    public function getPath(): JsonPointer
    {
        return $this->path;
    }

    /**
     * @param JsonValue $value
     * @return bool
     * @psalm-mutation-free
     */
    public function equals(JsonValue $value): bool
    {
        if (!$value instanceof self || count($this->properties) !== count($value->properties)) {
            return false;
        }

        foreach ($this->properties as $key => $property) {
            if (!$property->equals($value->properties[$key])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param non-empty-array<string, Keyword> $keywords
     * @return non-empty-list<ProcessedSchema>
     */
    public function processAsSchema(SchemaIdentifier $identifier, array $keywords): array
    {
        if (!$this->properties) {
            $validator = new ObjectSchemaValidator((string)$identifier, []);

            return [new ProcessedSchema($validator, $identifier, [], [], $this->path)];
        }

        $context = new SchemaContext($keywords, $identifier);

        foreach (array_intersect_key($keywords, $this->properties) as $keyword) {
            $keyword->process($this->properties, $context);
        }

        foreach (array_diff_key($this->properties, $keywords) as $name => $value) {
            $keywordIdentifier = $identifier->addTokens($name);
            $context->addKeywordHandler(new UnknownKeywordHandler((string)$keywordIdentifier, $name, $value));
        }

        $identifier = $context->getIdentifier();
        $anchors = $context->getAnchors();
        $references = $context->getReferences();

        $validator = new ObjectSchemaValidator((string)$identifier, $context->getKeywordHandlers());
        $processedSchema = new ProcessedSchema($validator, $identifier, $anchors, $references, $this->path);

        /** @var non-empty-list<ProcessedSchema> $processedSchemas */
        $processedSchemas = array_merge([$processedSchema], $context->getProcessedSchemas());

        return $processedSchemas;
    }
}
