<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary;

use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword\UnevaluatedItemsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword\UnevaluatedPropertiesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\Vocabulary;

/**
 * @psalm-immutable
 */
final class UnevaluatedVocabulary implements Vocabulary
{
    /**
     * @var non-empty-list<Keyword>
     */
    private $keywords;

    public function __construct()
    {
        $this->keywords = [
            new UnevaluatedItemsKeyword(),
            new UnevaluatedPropertiesKeyword(),
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
