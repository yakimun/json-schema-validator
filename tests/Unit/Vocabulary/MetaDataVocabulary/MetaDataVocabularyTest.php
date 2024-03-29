<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DefaultKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DeprecatedKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DescriptionKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\ExamplesKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\ReadOnlyKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\TitleKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\WriteOnlyKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\MetaDataVocabulary;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\MetaDataVocabulary
 */
final class MetaDataVocabularyTest extends TestCase
{
    public function testGetKeywords(): void
    {
        $vocabulary = new MetaDataVocabulary();
        $expected = [
            TitleKeyword::NAME => new TitleKeyword(),
            DescriptionKeyword::NAME => new DescriptionKeyword(),
            DefaultKeyword::NAME => new DefaultKeyword(),
            DeprecatedKeyword::NAME => new DeprecatedKeyword(),
            ReadOnlyKeyword::NAME => new ReadOnlyKeyword(),
            WriteOnlyKeyword::NAME => new WriteOnlyKeyword(),
            ExamplesKeyword::NAME => new ExamplesKeyword(),
        ];

        $this->assertEquals($expected, $vocabulary->getKeywords());
    }
}
