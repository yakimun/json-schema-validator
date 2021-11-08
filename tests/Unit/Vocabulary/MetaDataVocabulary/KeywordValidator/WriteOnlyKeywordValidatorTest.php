<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\WriteOnlyKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\WriteOnlyKeywordValidator
 */
final class WriteOnlyKeywordValidatorTest extends TestCase
{
    public function testGetWriteOnly(): void
    {
        $expected = true;
        $validator = new WriteOnlyKeywordValidator($expected);

        $this->assertSame($expected, $validator->getWriteOnly());
    }
}
