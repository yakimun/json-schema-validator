<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ThenKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ThenKeyword implements Keyword
{
    public const NAME = 'then';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        $validator = $context->createValidator($property, [self::NAME]);

        if (array_key_exists(IfKeyword::NAME, $context->getProperties())) {
            $context->addKeywordValidator(new ThenKeywordValidator($validator));
        }
    }
}
