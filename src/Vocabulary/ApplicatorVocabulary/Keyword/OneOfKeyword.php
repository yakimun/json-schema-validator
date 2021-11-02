<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\OneOfKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class OneOfKeyword implements Keyword
{
    public const NAME = 'oneOf';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (!is_array($property)) {
            throw $context->createException('The value must be an array.', self::NAME);
        }

        if (!$property) {
            throw $context->createException('The value must be a non-empty array.', self::NAME);
        }

        $validators = [];

        /**
         * @var list<mixed>|null|object|scalar $item
         */
        foreach (array_values($property) as $index => $item) {
            $validators[] = $context->createValidator($item, [self::NAME, (string)$index]);
        }

        $context->addKeywordValidator(new OneOfKeywordValidator($validators));
    }
}
