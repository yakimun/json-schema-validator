<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ArrayTypeKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator;

final class TypeKeyword implements Keyword
{
    public const NAME = 'type';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if ($property instanceof JsonString) {
            $value = $property->getValue();

            if (!in_array($value, ['null', 'boolean', 'object', 'array', 'number', 'string', 'integer'], true)) {
                $message = 'The value must be equal to "null", "boolean", "object", "array", "number", "string", or '
                    . '"integer".';
                throw $context->createException($message, self::NAME);
            }

            $context->addKeywordValidator(new StringTypeKeywordValidator($value));

            return;
        }

        if ($property instanceof JsonArray) {
            $types = [];

            foreach ($property->getElements() as $element) {
                if (!$element instanceof JsonString) {
                    throw $context->createException('Array elements must be strings.', self::NAME);
                }

                $value = $element->getValue();

                if (!in_array($value, ['null', 'boolean', 'object', 'array', 'number', 'string', 'integer'], true)) {
                    $message = 'The array elements must be equal to "null", "boolean", "object", "array", "number", '
                        . '"string", or "integer".';
                    throw $context->createException($message, self::NAME);
                }

                $types[] = $value;
            }

            if (array_unique($types) !== $types) {
                throw $context->createException('Array elements must be unique.', self::NAME);
            }

            $context->addKeywordValidator(new ArrayTypeKeywordValidator($types));

            return;
        }

        throw $context->createException('The value must be a string or an array.', self::NAME);
    }
}
