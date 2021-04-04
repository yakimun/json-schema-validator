<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Schema;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonFalse;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @psalm-immutable
 */
final class SchemaFactory
{
    /**
     * @var non-empty-array<string, Keyword>
     */
    private $keywords;

    /**
     * @param non-empty-array<string, Keyword> $keywords
     */
    public function __construct(array $keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @param JsonValue $value
     * @param SchemaIdentifier $identifier
     * @return Schema
     */
    public function createSchema(JsonValue $value, SchemaIdentifier $identifier): Schema
    {
        if ($value instanceof JsonObject) {
            return new ObjectSchema($value->getProperties(), $identifier, $this, $this->keywords);
        }

        if ($value instanceof JsonTrue) {
            return new TrueSchema($identifier);
        }

        if ($value instanceof JsonFalse) {
            return new FalseSchema($identifier);
        }

        $message = sprintf('The schema must be an object or a boolean. Path: "%s".', (string)$value->getPath());
        throw new InvalidSchemaException($message);
    }
}
