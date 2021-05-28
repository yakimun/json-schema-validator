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
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatMultipleOfKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerMultipleOfKeywordHandler;

final class MultipleOfKeyword implements Keyword
{
    private const NAME = 'multipleOf';

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
            $multipleOf = $property->getValue();

            if ($multipleOf <= 0) {
                $format = 'The value must be strictly greater than 0. Path: "%s".';
                throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME)));
            }

            $context->addKeywordHandler(new IntegerMultipleOfKeywordHandler((string)$keywordIdentifier, $multipleOf));

            return;
        }

        if ($property instanceof JsonFloat) {
            $multipleOf = $property->getValue();

            if ($multipleOf <= 0) {
                $format = 'The value must be strictly greater than 0. Path: "%s".';
                throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME)));
            }

            $context->addKeywordHandler(new FloatMultipleOfKeywordHandler((string)$keywordIdentifier, $multipleOf));

            return;
        }

        $message = sprintf('The value must be a number. Path: "%s".', (string)$path->addTokens(self::NAME));
        throw new InvalidSchemaException($message);
    }
}
