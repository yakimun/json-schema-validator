<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatMultipleOfKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerMultipleOfKeywordHandler;

final class MultipleOfKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'multipleOf';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['multipleOf'];
        $identifier = (string)$context->getIdentifier()->addTokens('multipleOf');

        if ($property instanceof JsonInteger) {
            $multipleOf = $property->getValue();

            if ($multipleOf <= 0) {
                $message = 'The value must be strictly greater than 0. Path: "%s".';
                throw new InvalidSchemaException(sprintf($message, (string)$property->getPath()));
            }

            $context->addKeywordHandler(new IntegerMultipleOfKeywordHandler($identifier, $multipleOf));

            return;
        }

        if ($property instanceof JsonFloat) {
            $multipleOf = $property->getValue();

            if ($multipleOf <= 0) {
                $message = 'The value must be strictly greater than 0. Path: "%s".';
                throw new InvalidSchemaException(sprintf($message, (string)$property->getPath()));
            }

            $context->addKeywordHandler(new FloatMultipleOfKeywordHandler($identifier, $multipleOf));

            return;
        }

        $message = sprintf('The value must be a number. Path: "%s".', (string)$property->getPath());
        throw new InvalidSchemaException($message);
    }
}
