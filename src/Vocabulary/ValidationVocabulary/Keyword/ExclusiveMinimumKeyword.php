<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatExclusiveMinimumKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerExclusiveMinimumKeywordHandler;

final class ExclusiveMinimumKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'exclusiveMinimum';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['exclusiveMinimum'];
        $identifier = (string)$context->getIdentifier()->addTokens('exclusiveMinimum');

        if ($property instanceof JsonInteger) {
            $context->addKeywordHandler(new IntegerExclusiveMinimumKeywordHandler($identifier, $property->getValue()));

            return;
        }

        if ($property instanceof JsonFloat) {
            $context->addKeywordHandler(new FloatExclusiveMinimumKeywordHandler($identifier, $property->getValue()));

            return;
        }

        $message = sprintf('The value must be a number. Path: "%s".', (string)$property->getPath());
        throw new InvalidSchemaException($message);
    }
}
