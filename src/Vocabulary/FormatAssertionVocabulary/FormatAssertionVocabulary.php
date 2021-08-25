<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary;

use Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\Keyword\FormatKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\Vocabulary;

/**
 * @psalm-immutable
 */
final class FormatAssertionVocabulary implements Vocabulary
{
    /**
     * @var non-empty-array<string, Keyword>
     */
    private array $keywords;

    public function __construct()
    {
        $this->keywords = [
            FormatKeyword::NAME => new FormatKeyword(),
        ];
    }

    /**
     * @return non-empty-array<string, Keyword>
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }
}
