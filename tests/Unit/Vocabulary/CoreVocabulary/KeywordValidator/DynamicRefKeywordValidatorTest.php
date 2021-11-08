<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\CoreVocabulary\KeywordValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicRefKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicRefKeywordValidator
 */
final class DynamicRefKeywordValidatorTest extends TestCase
{
    public function testGetDynamicRef(): void
    {
        $expected = new Uri('https://example.com');
        $validator = new DynamicRefKeywordValidator($expected);

        $this->assertSame($expected, $validator->getDynamicRef());
    }
}
