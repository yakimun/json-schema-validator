<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentSchemaKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ContentSchemaKeyword implements Keyword
{
    public const NAME = 'contentSchema';

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $validator = $context->createValidator($properties[self::NAME], self::NAME);

        if (array_key_exists(ContentMediaTypeKeyword::NAME, $properties)) {
            $context->addKeywordValidator(new ContentSchemaKeywordValidator($validator));
        }
    }
}
