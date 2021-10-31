<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\TitleKeywordValidator;

final class TitleKeyword implements Keyword
{
    public const NAME = 'title';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (!is_string($property)) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        $context->addKeywordValidator(new TitleKeywordValidator($property));
    }
}
