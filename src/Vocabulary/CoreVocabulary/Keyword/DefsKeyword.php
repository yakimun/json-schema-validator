<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DefsKeyword implements Keyword
{
    public const NAME = '$defs';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$property instanceof JsonObject) {
            throw $context->createException('The value must be an object.', self::NAME);
        }

        foreach ($property->getProperties() as $key => $value) {
            $context->createValidator($value, [self::NAME, $key]);
        }
    }
}
