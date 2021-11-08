<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicAnchorKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DynamicAnchorKeyword implements Keyword
{
    public const NAME = '$dynamicAnchor';

    /**
     * @param JsonValue $property
     * @param SchemaContext $context
     */
    public function process(JsonValue $property, SchemaContext $context): void
    {
        if (!$property instanceof JsonString) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        if (!preg_match('/^[A-Za-z_][A-Za-z0-9-_.]*$/', $property->getValue())) {
            $message = 'The value must start with a letter or underscore, followed by any number of letters, digits, ' .
                'hyphens, underscores, and periods.';
            throw $context->createException($message, self::NAME);
        }

        $dynamicAnchor = $context->getIdentifier()->getUri()->withFragment($property->getValue());

        $context->addAnchor($dynamicAnchor, true, self::NAME);
        $context->addKeywordValidator(new DynamicAnchorKeywordValidator($property->getValue()));
    }
}
