<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentSchemaKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ContentSchemaKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'contentSchema';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $identifier = $context->getIdentifier()->addTokens('contentSchema');
        $validator = $context->createValidator($properties['contentSchema'], $identifier);


        if (!($properties['contentMediaType'] ?? null)) {
            return;
        }

        $context->addKeywordHandler(new ContentSchemaKeywordHandler((string)$identifier, $validator));
    }
}
