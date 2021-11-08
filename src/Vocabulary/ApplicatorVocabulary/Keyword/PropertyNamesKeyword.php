<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PropertyNamesKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class PropertyNamesKeyword implements Keyword
{
    public const NAME = 'propertyNames';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        $validator = $context->createValidator($property, [self::NAME]);
        $context->addKeywordValidator(new PropertyNamesKeywordValidator($validator));
    }
}
