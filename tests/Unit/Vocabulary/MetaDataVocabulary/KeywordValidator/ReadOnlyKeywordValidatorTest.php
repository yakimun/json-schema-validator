<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ReadOnlyKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ReadOnlyKeywordValidator
 */
final class ReadOnlyKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = ReadOnlyKeywordValidator::class;

        $this->assertInstanceOf($expected, new ReadOnlyKeywordValidator(true));
    }
}
