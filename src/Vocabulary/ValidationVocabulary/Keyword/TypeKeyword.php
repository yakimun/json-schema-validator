<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ArrayTypeKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator;

final class TypeKeyword implements Keyword
{
    public const NAME = 'type';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        /** @var scalar|object|list<mixed>|null $property */
        $property = $properties[self::NAME];

        if (is_string($property)) {
            if (!in_array($property, ['null', 'boolean', 'object', 'array', 'number', 'string', 'integer'], true)) {
                $message = 'The value must be equal to "null", "boolean", "object", "array", "number", "string", or '
                    . '"integer".';
                throw $context->createException($message, self::NAME);
            }

            $context->addKeywordValidator(new StringTypeKeywordValidator($property));

            return;
        }

        if (is_array($property)) {
            $types = [];

            foreach (array_values($property) as $item) {
                if (!is_string($item)) {
                    throw $context->createException('Array elements must be strings.', self::NAME);
                }

                if (!in_array($item, ['null', 'boolean', 'object', 'array', 'number', 'string', 'integer'], true)) {
                    $message = 'The array elements must be equal to "null", "boolean", "object", "array", "number", '
                        . '"string", or "integer".';
                    throw $context->createException($message, self::NAME);
                }

                $types[] = $item;
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
