<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary;

use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\AnchorKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\CommentKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DefsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicAnchorKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicRefKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\IdKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\RefKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\SchemaKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\VocabularyKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\Vocabulary;

/**
 * @psalm-immutable
 */
final class CoreVocabulary implements Vocabulary
{
    /**
     * @var non-empty-array<string, Keyword>
     */
    private array $keywords;

    public function __construct()
    {
        $this->keywords = [
            SchemaKeyword::NAME => new SchemaKeyword(),
            VocabularyKeyword::NAME => new VocabularyKeyword(),
            IdKeyword::NAME => new IdKeyword(),
            AnchorKeyword::NAME => new AnchorKeyword(),
            DynamicAnchorKeyword::NAME => new DynamicAnchorKeyword(),
            RefKeyword::NAME => new RefKeyword(),
            DynamicRefKeyword::NAME => new DynamicRefKeyword(),
            DefsKeyword::NAME => new DefsKeyword(),
            CommentKeyword::NAME => new CommentKeyword(),
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
