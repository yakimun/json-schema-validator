<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\EnumKeywordValidator;

final class EnumKeyword implements Keyword
{
    public const NAME = 'enum';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (!is_array($property)) {
            throw $context->createException('The value must be an array.', self::NAME);
        }

        /**
         * @var list<list<mixed>|null|object|scalar> $elements
         */
        $elements = array_values($property);

        $context->addKeywordValidator(new EnumKeywordValidator($elements));
    }
}
