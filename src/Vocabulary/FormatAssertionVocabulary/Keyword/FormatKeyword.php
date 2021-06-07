<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\KeywordHandler\FormatKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class FormatKeyword implements Keyword
{
    private const NAME = 'format';

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

        if (!$property instanceof JsonString) {
            $message = sprintf('Value must be string at "%s"', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }

        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);

        $context->addKeywordHandler(new FormatKeywordHandler((string)$keywordIdentifier, $property->getValue()));
    }
}
