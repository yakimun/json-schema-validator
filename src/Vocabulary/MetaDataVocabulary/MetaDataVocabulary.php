<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary;

use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DefaultKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DeprecatedKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DescriptionKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\ExamplesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\ReadOnlyKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\TitleKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\WriteOnlyKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\Vocabulary;

/**
 * @psalm-immutable
 */
final class MetaDataVocabulary implements Vocabulary
{
    /**
     * @var non-empty-list<Keyword>
     */
    private $keywords;

    public function __construct()
    {
        $this->keywords = [
            new TitleKeyword(),
            new DescriptionKeyword(),
            new DefaultKeyword(),
            new DeprecatedKeyword(),
            new ReadOnlyKeyword(),
            new WriteOnlyKeyword(),
            new ExamplesKeyword(),
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
