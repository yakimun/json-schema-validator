<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\OneOfKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class OneOfKeyword implements Keyword
{
    private const NAME = 'oneOf';

    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param non-empty-array<string, mixed> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties[self::NAME];

        if (!is_array($property)) {
            throw $context->createException('The value must be an array.', self::NAME);
        }

        if (!$property) {
            throw $context->createException('The value must be a non-empty array.', self::NAME);
        }

        $validators = [];

        /** @var scalar|object|list<mixed>|null $item */
        foreach (array_values($property) as $index => $item) {
            $validators[] = $context->createValidator($item, self::NAME, (string)$index);
        }

        $context->addKeywordValidator(new OneOfKeywordValidator($validators));
    }
}
