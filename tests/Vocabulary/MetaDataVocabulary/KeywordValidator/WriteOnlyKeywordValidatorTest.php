<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\WriteOnlyKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\WriteOnlyKeywordValidator
 */
final class WriteOnlyKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = WriteOnlyKeywordValidator::class;

        $this->assertInstanceOf($expected, new WriteOnlyKeywordValidator(true));
    }
}
