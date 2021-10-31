<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ContentVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentMediaTypeKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentMediaTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentMediaTypeKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentMediaTypeKeywordValidator
 */
final class ContentMediaTypeKeywordTest extends TestCase
{
    /**
     * @var JsonPointer
     */
    private JsonPointer $pointer;

    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var ContentMediaTypeKeyword
     */
    private ContentMediaTypeKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->pointer = new JsonPointer();
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), $this->pointer, $this->pointer);
        $this->keyword = new ContentMediaTypeKeyword();
        $this->processor = new SchemaProcessor(['contentMediaType' => $this->keyword]);
    }

    public function testProcess(): void
    {
        $value = 'a';
        $context = new SchemaContext(
            $this->processor,
            ['contentMediaType' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );
        $expected = [new ContentMediaTypeKeywordValidator($value)];
        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context->getKeywordValidators());
    }

    public function testProcessWithInvalidValue(): void
    {
        $value = null;
        $context = new SchemaContext(
            $this->processor,
            ['contentMediaType' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }
}
