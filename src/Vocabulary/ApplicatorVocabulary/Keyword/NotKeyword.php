<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\NotKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class NotKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'not';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $identifier = $context->getIdentifier()->addTokens('not');
        $validator = $context->createValidator($properties['not'], $identifier);
        $context->addKeywordHandler(new NotKeywordHandler((string)$identifier, $validator));
    }
}
