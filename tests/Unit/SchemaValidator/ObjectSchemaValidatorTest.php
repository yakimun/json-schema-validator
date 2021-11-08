<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\SchemaValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator
 */
final class ObjectSchemaValidatorTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var JsonPointer
     */
    private JsonPointer $fragment;

    /**
     * @var KeywordValidator
     */
    private KeywordValidator $keywordValidator;

    /**
     * @var ObjectSchemaValidator
     */
    private ObjectSchemaValidator $validator;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->fragment = new JsonPointer([]);
        $this->keywordValidator = new StringTypeKeywordValidator('null');
        $this->validator = new ObjectSchemaValidator($this->uri, $this->fragment, [$this->keywordValidator]);
    }

    public function testGetUri(): void
    {
        $expected = $this->uri;

        $this->assertSame($expected, $this->validator->getUri());
    }

    public function testGetFragment(): void
    {
        $expected = $this->fragment;

        $this->assertSame($expected, $this->validator->getFragment());
    }

    public function testGetKeywordValidators(): void
    {
        $expected = [$this->keywordValidator];

        $this->assertSame($expected, $this->validator->getKeywordValidators());
    }
}
