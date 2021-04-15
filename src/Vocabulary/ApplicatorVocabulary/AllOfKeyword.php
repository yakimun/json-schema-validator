<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class AllOfKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'allOf';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['allOf'];

        if (!$property instanceof JsonArray) {
            $message = sprintf('The value must be an array. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $items = $property->getItems();

        if (!$items) {
            $message = sprintf('The value must be a non-empty array. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $identifier = $context->getIdentifier();
        $uri = $identifier->getUri();
        $fragment = $identifier->getFragment();

        $schemaValidators = [];

        foreach ($items as $index => $item) {
            $itemIdentifier = new SchemaIdentifier($uri, $fragment->addTokens('allOf', (string)$index));
            $schemaValidators[] = $context->createValidator($item, $itemIdentifier);
        }

        $context->addKeywordHandler(new AllOfKeywordHandler($schemaValidators));
    }
}
