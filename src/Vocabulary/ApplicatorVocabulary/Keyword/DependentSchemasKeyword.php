<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\DependentSchemasKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DependentSchemasKeyword implements Keyword
{
    public const NAME = 'dependentSchemas';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$property instanceof JsonObject) {
            throw $context->createException('The value must be an object.', self::NAME);
        }

        $validators = [];

        foreach ($property->getProperties() as $key => $value) {
            $validators[$key] = $context->createValidator($value, [self::NAME, $key]);
        }

        $context->addKeywordValidator(new DependentSchemasKeywordValidator($validators));
    }
}
