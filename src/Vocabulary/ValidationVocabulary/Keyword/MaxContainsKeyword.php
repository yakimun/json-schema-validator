<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxContainsKeywordHandler;

final class MaxContainsKeyword implements Keyword
{
    private const NAME = 'maxContains';

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

        if (!$property instanceof JsonInteger) {
            $message = sprintf('The value must be an integer. Path: "%s".', (string)$path->addTokens(self::NAME));
            throw new InvalidSchemaException($message);
        }

        $maxContains = $property->getValue();

        if ($maxContains < 0) {
            $format = 'The value must be a non-negative integer. Path: "%s".';
            throw new InvalidSchemaException(sprintf($format, (string)$path->addTokens(self::NAME)));
        }

        if (!($properties['contains'] ?? null)) {
            return;
        }

        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);

        $context->addKeywordHandler(new MaxContainsKeywordHandler((string)$keywordIdentifier, $maxContains));
    }
}
