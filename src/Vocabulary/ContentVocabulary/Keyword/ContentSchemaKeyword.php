<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentSchemaKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ContentSchemaKeyword implements Keyword
{
    private const NAME = 'contentSchema';

    private const CONTENT_MEDIA_TYPE_NAME = 'contentMediaType';

    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param JsonPointer $path
     * @param SchemaContext $context
     */
    public function process(array $properties, JsonPointer $path, SchemaContext $context): void
    {
        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);
        $keywordPath = $path->addTokens(self::NAME);

        $validator = $context->createValidator($properties[self::NAME], $keywordIdentifier, $keywordPath);

        if (!($properties[self::CONTENT_MEDIA_TYPE_NAME] ?? null)) {
            return;
        }

        $context->addKeywordHandler(new ContentSchemaKeywordHandler((string)$keywordIdentifier, $validator));
    }
}
