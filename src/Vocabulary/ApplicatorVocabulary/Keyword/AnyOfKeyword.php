<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AnyOfKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class AnyOfKeyword implements Keyword
{
    public const NAME = 'anyOf';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$property instanceof JsonArray) {
            throw $context->createException('The value must be an array.', self::NAME);
        }

        if (!$property->getElements()) {
            throw $context->createException('The value must be a non-empty array.', self::NAME);
        }

        $validators = [];

        foreach ($property->getElements() as $index => $element) {
            $validators[] = $context->createValidator($element, [self::NAME, (string)$index]);
        }

        $context->addKeywordValidator(new AnyOfKeywordValidator($validators));
    }
}
