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
     * @var non-empty-array<string, Keyword>
     */
    private array $keywords;

    public function __construct()
    {
        $this->keywords = [
            TitleKeyword::NAME => new TitleKeyword(),
            DescriptionKeyword::NAME => new DescriptionKeyword(),
            DefaultKeyword::NAME => new DefaultKeyword(),
            DeprecatedKeyword::NAME => new DeprecatedKeyword(),
            ReadOnlyKeyword::NAME => new ReadOnlyKeyword(),
            WriteOnlyKeyword::NAME => new WriteOnlyKeyword(),
            ExamplesKeyword::NAME => new ExamplesKeyword(),
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
