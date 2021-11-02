<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\CoreVocabulary\KeywordValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\RefKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\RefKeywordValidator
 */
final class RefKeywordValidatorTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $ref;

    /**
     * @var RefKeywordValidator
     */
    private RefKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->ref = new Uri('https://example.com');
        $this->validator = new RefKeywordValidator($this->ref);
    }

    public function testGetRef(): void
    {
        $expected = $this->ref;

        $this->assertSame($expected, $this->validator->getRef());
    }
}
