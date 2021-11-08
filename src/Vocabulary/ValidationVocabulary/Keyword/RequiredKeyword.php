<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\RequiredKeywordValidator;

final class RequiredKeyword implements Keyword
{
    public const NAME = 'required';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$property instanceof JsonArray) {
            throw $context->createException('The value must be an array.', self::NAME);
        }

        $requiredProperties = [];

        foreach ($property->getElements() as $element) {
            if (!$element instanceof JsonString) {
                throw $context->createException('Array elements must be strings.', self::NAME);
            }

            $value = $element->getValue();

            if (in_array($value, $requiredProperties, true)) {
                throw $context->createException('Array elements must be unique.', self::NAME);
            }

            $requiredProperties[] = $value;
        }

        $context->addKeywordValidator(new RequiredKeywordValidator($requiredProperties));
    }
}
