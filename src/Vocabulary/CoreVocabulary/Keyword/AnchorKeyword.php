<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class AnchorKeyword implements Keyword
{
    private const NAME = '$anchor';

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
            throw new InvalidSchemaException(sprintf('The value must be a string. Path: "%s".', (string)$keywordPath));
        }

        $anchor = $property->getValue();

        if (!preg_match('/^[A-Za-z_][A-Za-z0-9-_.]*$/', $anchor)) {
            $format = 'The value must start with a letter or underscore, followed by any number of letters, digits, '
                . 'hyphens, underscores, and periods. Path: "%s".';
            throw new InvalidSchemaException(sprintf($format, (string)$keywordPath));
        }

        $anchor = new SchemaReference($context->getIdentifier()->getUri()->withFragment($anchor), $keywordPath);
        $context->addAnchor($anchor);
    }
}
