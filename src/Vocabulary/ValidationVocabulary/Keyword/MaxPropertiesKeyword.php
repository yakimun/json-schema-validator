<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxPropertiesKeywordHandler;

final class MaxPropertiesKeyword implements Keyword
{
    private const NAME = 'maxProperties';

    /**
     * @return string
     * @psalm-mutation-free
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
        $property = $properties[self::NAME];

        if (!$property instanceof JsonInteger) {
            $message = sprintf('Value must be integer at "%s"', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }

        $maxProperties = $property->getValue();

        if ($maxProperties < 0) {
            $message = sprintf('Value must be non-negative integer at "%s"', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }

        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);

        $context->addKeywordHandler(new MaxPropertiesKeywordHandler((string)$keywordIdentifier, $maxProperties));
    }
}
