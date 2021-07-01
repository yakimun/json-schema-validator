<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\KeywordValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicRefKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicRefKeywordValidator
 */
final class DynamicRefKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = DynamicRefKeywordValidator::class;

        $this->assertInstanceOf($expected, new DynamicRefKeywordValidator(new Uri('https://example.com')));
    }
}
