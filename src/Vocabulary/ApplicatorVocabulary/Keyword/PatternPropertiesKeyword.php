<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\PatternPropertiesKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class PatternPropertiesKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'patternProperties';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['patternProperties'];

        if (!$property instanceof JsonObject) {
            $message = sprintf('The value must be an object. Path: "%s".', (string)$property->getPath());
            throw new InvalidSchemaException($message);
        }

        $identifier = $context->getIdentifier()->addTokens('patternProperties');
        $validators = [];

        foreach ($property->getProperties() as $key => $value) {
            $validators['/' . $key . '/'] = $context->createValidator($value, $identifier->addTokens($key));
        }

        $context->addKeywordHandler(new PatternPropertiesKeywordHandler((string)$identifier, $validators));
    }
}
