<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ExamplesKeywordValidator;

final class ExamplesKeyword implements Keyword
{
    public const NAME = 'examples';

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
         * @var list<list<mixed>|null|object|scalar> $examples
         */
        $examples = array_values($property);

        $context->addKeywordValidator(new ExamplesKeywordValidator($examples));
    }
}
