<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinContainsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MinContainsKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MinContainsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MinContainsKeywordHandler
 */
final class MinContainsKeywordTest extends TestCase
{
    /**
     * @var MinContainsKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new MinContainsKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('minContains', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['minContains' => $this->keyword], $identifier);
        $keywordHandler = new MinContainsKeywordHandler('https://example.com#/minContains', 1);
        $properties = ['contains' => new JsonBoolean(true), 'minContains' => new JsonInteger(1)];
        $this->keyword->process($properties, $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    public function testProcessWithInvalidValue(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['minContains' => $this->keyword], $identifier);
        $value = new JsonNull();

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['minContains' => $value], $pointer, $context);
    }

    public function testProcessWithNegativeInteger(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['minContains' => $this->keyword], $identifier);
        $value = new JsonInteger(-1);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['minContains' => $value], $pointer, $context);
    }

    public function testProcessWithoutContains(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['minContains' => $this->keyword], $identifier);
        $this->keyword->process(['minContains' => new JsonInteger(1)], $pointer, $context);

        $this->assertEmpty($context->getKeywordHandlers());
    }
}
