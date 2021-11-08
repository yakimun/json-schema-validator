<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\DependentRequiredKeywordValidator;

final class DependentRequiredKeyword implements Keyword
{
    public const NAME = 'dependentRequired';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$property instanceof JsonObject) {
            throw $context->createException('The value must be an object.', self::NAME);
        }

        $dependentRequiredProperties = [];

        foreach ($property->getProperties() as $objectKey => $objectProperty) {
            if (!$objectProperty instanceof JsonArray) {
                throw $context->createException('Object property values must be arrays.', self::NAME);
            }

            $dependentRequiredProperties[$objectKey] = [];

            foreach ($objectProperty->getElements() as $element) {
                if (!$element instanceof JsonString) {
                    $message = 'Object property values must contain only string elements.';
                    throw $context->createException($message, self::NAME);
                }

                $value = $element->getValue();

                if (in_array($value, $dependentRequiredProperties[$objectKey], true)) {
                    throw $context->createException('Object property values must be unique.', self::NAME);
                }

                $dependentRequiredProperties[$objectKey][] = $value;
            }
        }

        $context->addKeywordValidator(new DependentRequiredKeywordValidator($dependentRequiredProperties));
    }
}
