<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PropertiesKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class PropertiesKeyword implements Keyword
{
    public const NAME = 'properties';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (!is_object($property)) {
            throw $context->createException('The value must be an object.', self::NAME);
        }

        $validators = [];

        /**
         * @var list<mixed>|null|object|scalar $value
         */
        foreach (get_object_vars($property) as $key => $value) {
            $validators[$key] = $context->createValidator($value, [self::NAME, $key]);
        }

        $context->addKeywordValidator(new PropertiesKeywordValidator($validators));
    }
}
