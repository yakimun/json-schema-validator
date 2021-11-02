<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\CoreVocabulary\KeywordValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicRefKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicRefKeywordValidator
 */
final class DynamicRefKeywordValidatorTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $dynamicRef;

    /**
     * @var DynamicRefKeywordValidator
     */
    private DynamicRefKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->dynamicRef = new Uri('https://example.com');
        $this->validator = new DynamicRefKeywordValidator($this->dynamicRef);
    }

    public function testGetDynamicRef(): void
    {
        $expected = $this->dynamicRef;

        $this->assertSame($expected, $this->validator->getDynamicRef());
    }
}
