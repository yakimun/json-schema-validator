<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary;

use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaReference;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class AnchorKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return '$anchor';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['$anchor'];

        $path = $property->getPath();

        if (!$property instanceof JsonString) {
            throw new InvalidSchemaException(sprintf('The value must be a string. Path: "%s".', (string)$path));
        }

        $anchor = $property->getValue();

        if (!preg_match('/^[A-Za-z_][A-Za-z0-9-_.]*$/', $anchor)) {
            $format = 'The value must start with a letter or underscore, followed by any number of letters, digits, '
                . 'hyphens, underscores, and periods. Path: "%s".';
            throw new InvalidSchemaException(sprintf($format, (string)$path));
        }

        $context->addAnchor(new SchemaReference($context->getIdentifier()->getUri()->withFragment($anchor), $path));
    }
}
