<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\UniqueItemsKeywordHandler;

final class UniqueItemsKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'uniqueItems';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['uniqueItems'];
        $identifier = (string)$context->getIdentifier()->addTokens('uniqueItems');

        if (!$property instanceof JsonBoolean) {
            $message = sprintf('The value must be a boolean. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $context->addKeywordHandler(new UniqueItemsKeywordHandler($identifier, $property->getValue()));
    }
}
