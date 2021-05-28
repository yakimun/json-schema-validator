<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\PropertiesKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class PropertiesKeyword implements Keyword
{
    private const NAME = 'properties';

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
            $message = sprintf('The value must be an object. Path: "%s".', (string)$keywordPath);
            throw new InvalidSchemaException($message);
        }

        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);
        $validators = [];

        foreach ($property->getProperties() as $key => $value) {
            $valueIdentifier = $keywordIdentifier->addTokens($key);
            $valuePath = $keywordPath->addTokens($key);

            $validators[$key] = $context->createValidator($value, $valueIdentifier, $valuePath);
        }

        $context->addKeywordHandler(new PropertiesKeywordHandler((string)$keywordIdentifier, $validators));
    }
}
