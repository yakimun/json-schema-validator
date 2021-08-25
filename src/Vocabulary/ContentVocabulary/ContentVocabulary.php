<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary;

use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentEncodingKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentMediaTypeKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentSchemaKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\Vocabulary;

/**
 * @psalm-immutable
 */
final class ContentVocabulary implements Vocabulary
{
    /**
     * @var non-empty-array<string, Keyword>
     */
    private array $keywords;

    public function __construct()
    {
        $this->keywords = [
            ContentEncodingKeyword::NAME => new ContentEncodingKeyword(),
            ContentMediaTypeKeyword::NAME => new ContentMediaTypeKeyword(),
            ContentSchemaKeyword::NAME => new ContentSchemaKeyword(),
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
