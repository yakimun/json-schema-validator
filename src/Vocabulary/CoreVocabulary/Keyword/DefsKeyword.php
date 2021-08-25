<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DefsKeyword implements Keyword
{
    public const NAME = '$defs';

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

        /** @var scalar|object|list<mixed>|null $value */
        foreach (get_object_vars($property) as $key => $value) {
            $context->createValidator($value, self::NAME, $key);
        }
    }
}
