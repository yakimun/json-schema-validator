<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary;

use Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\Keyword\FormatKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\Vocabulary;

/**
 * @psalm-immutable
 */
final class FormatAnnotationVocabulary implements Vocabulary
{
    /**
     * @var non-empty-list<Keyword>
     */
    private array $keywords;

    public function __construct()
    {
        $this->keywords = [
            new FormatKeyword(),
        ];
    }

    /**
     * @return non-empty-list<Keyword>
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }
}
