<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\RequiredKeywordValidator;

final class RequiredKeyword implements Keyword
{
    private const NAME = 'required';

    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties[self::NAME];

        if (!is_array($property)) {
            throw $context->createException('The value must be an array.', self::NAME);
        }

        $requiredProperties = [];

        foreach (array_values($property) as $index => $item) {
            if (!is_string($item)) {
                throw $context->createException('The element must be a string.', self::NAME, (string)$index);
            }

            if (in_array($item, $requiredProperties, true)) {
                throw $context->createException('Elements must be unique.', self::NAME);
            }

            $requiredProperties[] = $item;
        }

        $context->addKeywordValidator(new RequiredKeywordValidator($requiredProperties));
    }
}
