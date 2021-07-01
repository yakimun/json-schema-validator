<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ContentVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentMediaTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentMediaTypeKeywordValidator
 */
final class ContentMediaTypeKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = ContentMediaTypeKeywordValidator::class;

        $this->assertInstanceOf($expected, new ContentMediaTypeKeywordValidator('a'));
    }
}
