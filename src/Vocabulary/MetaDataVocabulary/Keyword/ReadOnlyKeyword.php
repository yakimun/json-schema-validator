<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ReadOnlyKeywordValidator;

final class ReadOnlyKeyword implements Keyword
{
    public const NAME = 'readOnly';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (!is_bool($property)) {
            throw $context->createException('The value must be a boolean.', self::NAME);
        }

        $context->addKeywordValidator(new ReadOnlyKeywordValidator($property));
    }
}
