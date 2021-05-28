<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

final class ElseKeyword implements Keyword
{
    private const NAME = 'else';

    private const IF_NAME = 'if';

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
        if ($properties[self::IF_NAME] ?? null) {
            return;
        }

        $keywordIdentifier = $context->getIdentifier()->addTokens(self::NAME);
        $keywordPath = $path->addTokens(self::NAME);

        $context->createValidator($properties[self::NAME], $keywordIdentifier, $keywordPath);
    }
}
