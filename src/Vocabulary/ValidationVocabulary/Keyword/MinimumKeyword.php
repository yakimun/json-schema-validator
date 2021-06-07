<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatMinimumKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerMinimumKeywordHandler;

final class MinimumKeyword implements Keyword
{
    private const NAME = 'minimum';

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
        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);

        if ($property instanceof JsonInteger) {
            $keywordHandler = new IntegerMinimumKeywordHandler((string)$keywordIdentifier, $property->getValue());
            $context->addKeywordHandler($keywordHandler);

            return;
        }

        if ($property instanceof JsonFloat) {
            $keywordHandler = new FloatMinimumKeywordHandler((string)$keywordIdentifier, $property->getValue());
            $context->addKeywordHandler($keywordHandler);

            return;
        }

        throw new InvalidSchemaException(sprintf('Value must be number at "%s"', (string)$path->addTokens(self::NAME)));
    }
}
