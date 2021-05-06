<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\DependentSchemasKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DependentSchemasKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'dependentSchemas';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['dependentSchemas'];

        if (!$property instanceof JsonObject) {
            $message = sprintf('The value must be an object. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $identifier = $context->getIdentifier()->addTokens('dependentSchemas');
        $validators = [];

        foreach ($property->getProperties() as $key => $value) {
            $validators[$key] = $context->createValidator($value, $identifier->addTokens($key));
        }

        $context->addKeywordHandler(new DependentSchemasKeywordHandler((string)$identifier, $validators));
    }
}
