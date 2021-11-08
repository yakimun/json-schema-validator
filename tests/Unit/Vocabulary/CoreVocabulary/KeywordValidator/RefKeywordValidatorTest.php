<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\CoreVocabulary\KeywordValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\RefKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\RefKeywordValidator
 */
final class RefKeywordValidatorTest extends TestCase
{
    public function testGetRef(): void
    {
        $expected = new Uri('https://example.com');
        $validator = new RefKeywordValidator($expected);

        $this->assertSame($expected, $validator->getRef());
    }
}
