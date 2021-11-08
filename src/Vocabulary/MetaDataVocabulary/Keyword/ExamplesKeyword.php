<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ExamplesKeywordValidator;

final class ExamplesKeyword implements Keyword
{
    public const NAME = 'examples';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$property instanceof JsonArray) {
            throw $context->createException('The value must be an array.', self::NAME);
        }

        $context->addKeywordValidator(new ExamplesKeywordValidator($property->getElements()));
    }
}
