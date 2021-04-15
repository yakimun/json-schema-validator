<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class UnevaluatedItemsKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'unevaluatedItems';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['unevaluatedItems'];

        $identifier = $context->getIdentifier();
        $uri = $identifier->getUri();
        $fragment = $identifier->getFragment();

        $unevaluatedItemsIdentifier = new SchemaIdentifier($uri, $fragment->addTokens('unevaluatedItems'));

        $schemaValidator = $context->createValidator($property, $unevaluatedItemsIdentifier);
        $context->addKeywordHandler(new UnevaluatedItemsKeywordHandler($schemaValidator));
    }
}
