<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Json;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @psalm-immutable
 */
final class JsonArray implements JsonValue
{
    /**
     * @var list<JsonValue>
     */
    private $items;

    /**
     * @param list<JsonValue> $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return list<JsonValue>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param JsonValue $value
     * @return bool
     */
    public function equals(JsonValue $value): bool
    {
        if (!$value instanceof self || count($this->items) !== count($value->items)) {
            return false;
        }

        foreach ($this->items as $index => $item) {
            if (!$item->equals($value->items[$index])) {
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
        throw new InvalidSchemaException(sprintf('Schema must be object or boolean at "%s"', (string)$path));
    }
}
