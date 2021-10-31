<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DefsKeyword implements Keyword
{
    public const NAME = '$defs';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (!is_object($property)) {
            throw $context->createException('The value must be an object.', self::NAME);
        }

        /**
         * @var list<mixed>|null|object|scalar $value
         */
        foreach (get_object_vars($property) as $key => $value) {
            $context->createValidator($value, self::NAME, $key);
        }
    }
}
