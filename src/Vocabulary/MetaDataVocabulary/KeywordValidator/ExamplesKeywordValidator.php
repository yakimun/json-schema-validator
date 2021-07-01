<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class ExamplesKeywordValidator implements KeywordValidator
{
    /**
     * @var list<mixed>
     */
    private array $examples;

    /**
     * @param list<mixed> $examples
     */
    public function __construct(array $examples)
    {
        $this->examples = $examples;
    }
}
