<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\DependentSchemasKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DependentSchemasKeyword implements Keyword
{
    private const NAME = 'dependentSchemas';

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

        $validators = [];

        /**
         * @var scalar|object|list<mixed>|null $value
         */
        foreach (get_object_vars($property) as $key => $value) {
            $validators[$key] = $context->createValidator($value, self::NAME, $key);
        }

        $context->addKeywordValidator(new DependentSchemasKeywordValidator($validators));
    }
}
