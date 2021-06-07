<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\PatternPropertiesKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class PatternPropertiesKeyword implements Keyword
{
    private const NAME = 'patternProperties';

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
        $validators = [];

        foreach ($property->getProperties() as $key => $value) {
            $valueIdentifier = $keywordIdentifier->addTokens($key);
            $valuePath = $keywordPath->addTokens($key);

            $validators['/' . $key . '/'] = $context->createValidator($value, $valueIdentifier, $valuePath);
        }

        $context->addKeywordHandler(new PatternPropertiesKeywordHandler((string)$keywordIdentifier, $validators));
    }
}
