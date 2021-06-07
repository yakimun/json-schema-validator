<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @psalm-immutable
 */
final class CommentKeyword implements Keyword
{
    private const NAME = '$comment';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param JsonPointer $path
     * @param SchemaContext $context
     */
    public function process(array $properties, JsonPointer $path, SchemaContext $context): void
    {
        if (!$properties[self::NAME] instanceof JsonString) {
            $message = sprintf('Value must be string at "%s"', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }
    }
}
