<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\DynamicAnchorKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DynamicAnchorKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return '$dynamicAnchor';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['$dynamicAnchor'];

        $path = $property->getPath();

        if (!$property instanceof JsonString) {
            throw new InvalidSchemaException(sprintf('The value must be a string. Path: "%s".', (string)$path));
        }

        $dynamicAnchor = $property->getValue();

        if (!preg_match('/^[A-Za-z_][A-Za-z0-9-_.]*$/', $dynamicAnchor)) {
            $format = 'The value must start with a letter or underscore, followed by any number of letters, digits, '
                . 'hyphens, underscores, and periods. Path: "%s".';
            throw new InvalidSchemaException(sprintf($format, (string)$path));
        }

        $reference = new SchemaReference($context->getIdentifier()->getUri()->withFragment($dynamicAnchor), $path);
        $context->addAnchor($reference);
        $context->addKeywordHandler(new DynamicAnchorKeywordHandler($dynamicAnchor));
    }
}
