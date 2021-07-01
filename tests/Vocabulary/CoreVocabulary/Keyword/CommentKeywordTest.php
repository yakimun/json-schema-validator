<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\CommentKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\CommentKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 */
final class CommentKeywordTest extends TestCase
{
    /**
     * @var CommentKeyword
     */
    private CommentKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new CommentKeyword();

        $pointer = new JsonPointer();

        $processor = new SchemaProcessor(['$comment' => $this->keyword]);
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer, $pointer);

        $this->context = new SchemaContext($processor, $identifier, $pointer);
    }

    public function testGetName(): void
    {
        $this->assertSame('$comment', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $expected = clone $this->context;

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $this->keyword->process(['$comment' => 'a'], $this->context);

        $this->assertEquals($expected, $this->context);
    }

    public function testProcessWithInvalidValue(): void
    {
        $this->expectException(SchemaException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $this->keyword->process(['$comment' => null], $this->context);
    }
}
