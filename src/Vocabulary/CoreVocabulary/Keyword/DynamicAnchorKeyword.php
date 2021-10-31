<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicAnchorKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DynamicAnchorKeyword implements Keyword
{
    public const NAME = '$dynamicAnchor';

    /**
     * @param list<mixed>|null|object|scalar $property
     * @param SchemaContext $context
     */
    public function process($property, SchemaContext $context): void
    {
        if (!is_string($property)) {
            throw $context->createException('The value must be a string.', self::NAME);
        }

        if (!preg_match('/^[A-Za-z_][A-Za-z0-9-_.]*$/', $property)) {
            $message = 'The value must start with a letter or underscore, followed by any number of letters, digits, ' .
                'hyphens, underscores, and periods.';
            throw $context->createException($message, self::NAME);
        }

        $context->addAnchor($context->getIdentifier()->getUri()->withFragment($property), true, self::NAME);
        $context->addKeywordValidator(new DynamicAnchorKeywordValidator($property));
    }
}
