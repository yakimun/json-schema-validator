<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\DependentRequiredKeywordValidator;

final class DependentRequiredKeyword implements Keyword
{
    private const NAME = 'dependentRequired';

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

        if (!is_object($property)) {
            throw $context->createException('The value must be an object.', self::NAME);
        }

        $dependentRequiredProperties = [];

        foreach (get_object_vars($property) as $key => $objectProperty) {
            if (!is_array($objectProperty)) {
                throw $context->createException('The property must be an array.', self::NAME, $key);
            }

            $dependentRequiredProperties[$key] = [];

            /** @var scalar|object|list<mixed>|null $item */
            foreach (array_values($objectProperty) as $index => $item) {
                if (!is_string($item)) {
                    throw $context->createException('The element must be a string.', self::NAME, $key, (string)$index);
                }

                if (in_array($item, $dependentRequiredProperties[$key], true)) {
                    throw $context->createException('Elements must be unique.', self::NAME, $key);
                }

                $dependentRequiredProperties[$key][] = $item;
            }
        }

        $context->addKeywordValidator(new DependentRequiredKeywordValidator($dependentRequiredProperties));
    }
}
