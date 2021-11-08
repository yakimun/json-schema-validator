<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\TitleKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\TitleKeywordValidator
 */
final class TitleKeywordValidatorTest extends TestCase
{
    public function testGetTitle(): void
    {
        $expected = 'a';
        $validator = new TitleKeywordValidator($expected);

        $this->assertSame($expected, $validator->getTitle());
    }
}
