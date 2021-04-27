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
     * @var non-empty-list<Keyword>
     */
    private $keywords;

    public function __construct()
    {
        $this->keywords = [
            new SchemaKeyword(),
            new VocabularyKeyword(),
            new IdKeyword(),
            new AnchorKeyword(),
            new DynamicAnchorKeyword(),
            new RefKeyword(),
            new DynamicRefKeyword(),
            new DefsKeyword(),
            new CommentKeyword(),
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
