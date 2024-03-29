<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ElseKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ElseKeyword implements Keyword
{
    public const NAME = 'else';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        $validator = $context->createValidator($property, [self::NAME]);

        if (array_key_exists(IfKeyword::NAME, $context->getProperties())) {
            $context->addKeywordValidator(new ElseKeywordValidator($validator));
        }
    }
}
