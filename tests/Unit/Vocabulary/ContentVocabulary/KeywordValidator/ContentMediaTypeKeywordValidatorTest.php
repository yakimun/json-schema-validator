<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ContentVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentMediaTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentMediaTypeKeywordValidator
 */
final class ContentMediaTypeKeywordValidatorTest extends TestCase
{
    public function testGetContentMediaType(): void
    {
        $expected = 'a';
        $validator = new ContentMediaTypeKeywordValidator($expected);

        $this->assertSame($expected, $validator->getContentMediaType());
    }
}
