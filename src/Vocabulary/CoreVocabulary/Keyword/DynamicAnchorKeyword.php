<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler\DynamicAnchorKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class DynamicAnchorKeyword implements Keyword
{
    private const NAME = '$dynamicAnchor';

    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param JsonPointer $path
     * @param SchemaContext $context
     */
    public function process(array $properties, JsonPointer $path, SchemaContext $context): void
    {
        $property = $properties[self::NAME];
        $keywordPath = $path->addTokens(self::NAME);

        if (!$property instanceof JsonString) {
            throw new InvalidSchemaException(sprintf('Value must be string at "%s"', (string)$keywordPath));
        }

        $dynamicAnchor = $property->getValue();

        if (!preg_match('/^[A-Za-z_][A-Za-z0-9-_.]*$/', $dynamicAnchor)) {
            $format = 'Value must start with letter or underscore, followed by any number of letters, digits, hyphens, '
                . 'underscores, and periods at "%s"';
            throw new InvalidSchemaException(sprintf($format, (string)$keywordPath));
        }

        $identifier = $context->getIdentifier();
        $keywordIdentifier = $identifier->addTokens(self::NAME);

        $context->addAnchor(new SchemaReference($identifier->getUri()->withFragment($dynamicAnchor), $keywordPath));
        $context->addKeywordHandler(new DynamicAnchorKeywordHandler((string)$keywordIdentifier, $dynamicAnchor));
    }
}
