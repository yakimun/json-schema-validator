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
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatExclusiveMinimumKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerExclusiveMinimumKeywordHandler;

final class ExclusiveMinimumKeyword implements Keyword
{
    private const NAME = 'exclusiveMinimum';

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
            $context->addKeywordHandler(new IntegerExclusiveMinimumKeywordHandler(
                (string)$keywordIdentifier,
                $property->getValue(),
            ));

            return;
        }

        if ($property instanceof JsonFloat) {
            $context->addKeywordHandler(new FloatExclusiveMinimumKeywordHandler(
                (string)$keywordIdentifier,
                $property->getValue(),
            ));

            return;
        }

        throw new InvalidSchemaException(sprintf('Value must be number at "%s"', (string)$path->addTokens(self::NAME)));
    }
}
