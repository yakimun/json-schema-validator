<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ContentVocabulary\KeywordValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentSchemaKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentSchemaKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class ContentSchemaKeywordValidatorTest extends TestCase
{
    public function testGetSchemaValidator(): void
    {
        $expected = new ObjectSchemaValidator(new Uri('https://example.com'), new JsonPointer([]), []);
        $validator = new ContentSchemaKeywordValidator($expected);

        $this->assertSame($expected, $validator->getSchemaValidator());
    }
}
