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
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaxContainsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxContainsKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\MaxContainsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\MaxContainsKeywordHandler
 */
final class MaxContainsKeywordTest extends TestCase
{
    /**
     * @var MaxContainsKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new MaxContainsKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('maxContains', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['maxContains' => $this->keyword], $identifier);
        $keywordHandler = new MaxContainsKeywordHandler('https://example.com#/maxContains', 1);
        $properties = [
            'contains' => new JsonBoolean(true, new JsonPointer()),
            'maxContains' => new JsonInteger(1, new JsonPointer()),
        ];
        $this->keyword->process($properties, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    public function testProcessWithInvalidValue(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['maxContains' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['maxContains' => new JsonNull(new JsonPointer())], $context);
    }

    public function testProcessWithNegativeInteger(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['maxContains' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['maxContains' => new JsonInteger(-1, new JsonPointer())], $context);
    }

    public function testProcessWithoutContains(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['maxContains' => $this->keyword], $identifier);
        $this->keyword->process(['maxContains' => new JsonInteger(1, new JsonPointer())], $context);

        $this->assertEmpty($context->getKeywordHandlers());
    }
}
