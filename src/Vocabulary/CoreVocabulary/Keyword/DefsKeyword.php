<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DefsKeyword implements Keyword
{
    private const NAME = '$defs';

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
        $keywordPath = $path->addTokens(self::NAME);

        if (!$property instanceof JsonObject) {
            throw new InvalidSchemaException(sprintf('Value must be object at "%s"', (string)$keywordPath));
        }

        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);

        foreach ($property->getProperties() as $key => $value) {
            $context->createValidator($value, $keywordIdentifier->addTokens($key), $keywordPath->addTokens($key));
        }
    }
}
