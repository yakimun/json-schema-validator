<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MinLengthKeywordHandler;

final class MinLengthKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'minLength';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['minLength'];
        $identifier = (string)$context->getIdentifier()->addTokens('minLength');

        if (!$property instanceof JsonInteger) {
            $message = sprintf('The value must be an integer. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $minLength = $property->getValue();

        if ($minLength < 0) {
            $message = sprintf('The value must be a non-negative integer. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $context->addKeywordHandler(new MinLengthKeywordHandler($identifier, $minLength));
    }
}
