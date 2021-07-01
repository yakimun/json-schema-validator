<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ContentVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentEncodingKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentEncodingKeywordValidator
 */
final class ContentEncodingKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = ContentEncodingKeywordValidator::class;

        $this->assertInstanceOf($expected, new ContentEncodingKeywordValidator('a'));
    }
}
