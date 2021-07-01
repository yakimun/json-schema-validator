<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\KeywordValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\RefKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\RefKeywordValidator
 */
final class RefKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = RefKeywordValidator::class;

        $this->assertInstanceOf($expected, new RefKeywordValidator(new Uri('https://example.com')));
    }
}
