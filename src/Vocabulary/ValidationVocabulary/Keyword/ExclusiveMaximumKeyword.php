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
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatExclusiveMaximumKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerExclusiveMaximumKeywordHandler;

final class ExclusiveMaximumKeyword implements Keyword
{
    private const NAME = 'exclusiveMaximum';

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
            $context->addKeywordHandler(new IntegerExclusiveMaximumKeywordHandler(
                (string)$keywordIdentifier,
                $property->getValue(),
            ));

            return;
        }

        if ($property instanceof JsonFloat) {
            $context->addKeywordHandler(new FloatExclusiveMaximumKeywordHandler(
                (string)$keywordIdentifier,
                $property->getValue(),
            ));

            return;
        }

        $message = sprintf('The value must be a number. Path: "%s".', (string)$path->addTokens(self::NAME));
        throw new InvalidSchemaException($message);
    }
}
