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
     * @var list<list<mixed>|null|object|scalar>
     */
    private array $examples;

    /**
     * @param list<list<mixed>|null|object|scalar> $examples
     */
    public function __construct(array $examples)
    {
        $this->examples = $examples;
    }
}
