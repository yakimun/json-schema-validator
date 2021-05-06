<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\AnyOfKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class AnyOfKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'anyOf';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['anyOf'];

        if (!$property instanceof JsonArray) {
            $message = sprintf('The value must be an array. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $items = $property->getItems();

        if (!$items) {
            $message = sprintf('The value must be a non-empty array. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $identifier = $context->getIdentifier()->addTokens('anyOf');
        $validators = [];

        foreach ($items as $index => $item) {
            $validators[] = $context->createValidator($item, $identifier->addTokens((string)$index));
        }

        $context->addKeywordHandler(new AnyOfKeywordHandler((string)$identifier, $validators));
    }
}
