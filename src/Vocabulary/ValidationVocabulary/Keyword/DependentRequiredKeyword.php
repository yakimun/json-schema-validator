<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\DependentRequiredKeywordValidator;

final class DependentRequiredKeyword implements Keyword
{
    public const NAME = 'dependentRequired';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (!is_object($property)) {
            throw $context->createException('The value must be an object.', self::NAME);
        }

        $dependentRequiredProperties = [];

        foreach (get_object_vars($property) as $key => $objectProperty) {
            if (!is_array($objectProperty)) {
                throw $context->createException('Object property values must be arrays.', self::NAME);
            }

            $dependentRequiredProperties[$key] = [];

            /**
             * @var list<mixed>|null|object|scalar $item
             */
            foreach (array_values($objectProperty) as $item) {
                if (!is_string($item)) {
                    $message = 'Object property values must contain only string elements.';
                    throw $context->createException($message, self::NAME);
                }

                if (in_array($item, $dependentRequiredProperties[$key], true)) {
                    throw $context->createException('Object property values must be unique.', self::NAME);
                }

                $dependentRequiredProperties[$key][] = $item;
            }
        }

        $context->addKeywordValidator(new DependentRequiredKeywordValidator($dependentRequiredProperties));
    }
}
