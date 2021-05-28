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
     * @param array<string, JsonValue> $properties
     */
    public function __construct(array $properties)
    {
        $this->properties = $properties;
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
     * @param SchemaIdentifier $identifier
     * @param non-empty-array<string, Keyword> $keywords
     * @param JsonPointer $path
     * @return non-empty-list<ProcessedSchema>
     */
    public function processAsSchema(SchemaIdentifier $identifier, array $keywords, JsonPointer $path): array
    {
        if (!$this->properties) {
            $validator = new ObjectSchemaValidator((string)$identifier, []);

            return [new ProcessedSchema($validator, $identifier, [], [], $path)];
        }

        $context = new SchemaContext($keywords, $identifier);

        foreach (array_intersect_key($keywords, $this->properties) as $keyword) {
            $keyword->process($this->properties, $path, $context);
        }

        foreach (array_diff_key($this->properties, $keywords) as $name => $value) {
            $keywordIdentifier = $identifier->addTokens($name);
            $context->addKeywordHandler(new UnknownKeywordHandler((string)$keywordIdentifier, $name, $value));
        }

        $identifier = $context->getIdentifier();
        $anchors = $context->getAnchors();
        $references = $context->getReferences();

        $validator = new ObjectSchemaValidator((string)$identifier, $context->getKeywordHandlers());
        $processedSchema = new ProcessedSchema($validator, $identifier, $anchors, $references, $path);

        /** @var non-empty-list<ProcessedSchema> $processedSchemas */
        $processedSchemas = array_merge([$processedSchema], $context->getProcessedSchemas());

        return $processedSchemas;
    }
}
