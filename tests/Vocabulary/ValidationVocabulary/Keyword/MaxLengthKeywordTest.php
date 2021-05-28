<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaxLengthKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxLengthKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaxLengthKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxLengthKeywordHandler
 */
final class MaxLengthKeywordTest extends TestCase
{
    /**
     * @var MaxLengthKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new MaxLengthKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('maxLength', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['maxLength' => $this->keyword], $identifier);
        $keywordHandler = new MaxLengthKeywordHandler('https://example.com#/maxLength', 1);
        $this->keyword->process(['maxLength' => new JsonInteger(1)], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    public function testProcessWithInvalidValue(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['maxLength' => $this->keyword], $identifier);
        $value = new JsonNull();

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['maxLength' => $value], $pointer, $context);
    }

    public function testProcessWithNegativeInteger(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['maxLength' => $this->keyword], $identifier);
        $value = new JsonInteger(-1);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['maxLength' => $value], $pointer, $context);
    }
}
