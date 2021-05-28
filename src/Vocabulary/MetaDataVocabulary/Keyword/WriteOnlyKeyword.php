<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\WriteOnlyKeywordHandler;

final class WriteOnlyKeyword implements Keyword
{
    private const NAME = 'writeOnly';

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

        if (!$property instanceof JsonBoolean) {
            $message = sprintf('The value must be a boolean. Path: "%s".', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }

        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);

        $context->addKeywordHandler(new WriteOnlyKeywordHandler((string)$keywordIdentifier, $property->getValue()));
    }
}
