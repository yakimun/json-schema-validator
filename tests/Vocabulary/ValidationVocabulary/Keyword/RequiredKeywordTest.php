<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\RequiredKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\RequiredKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\RequiredKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\RequiredKeywordHandler
 */
final class RequiredKeywordTest extends TestCase
{
    /**
     * @var RequiredKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new RequiredKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('required', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['required' => $this->keyword], $identifier);
        $keywordHandler = new RequiredKeywordHandler('https://example.com#/required', ['a']);
        $properties = ['required' => new JsonArray([new JsonString('a', new JsonPointer('0'))], new JsonPointer())];
        $this->keyword->process($properties, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    public function testProcessWithInvalidValue(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['required' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['required' => new JsonNull(new JsonPointer())], $context);
    }

    public function testProcessWithInvalidArrayItem(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['required' => $this->keyword], $identifier);
        $items = [new JsonNull(new JsonPointer('0'))];

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['required' => new JsonArray($items, new JsonPointer())], $context);
    }

    public function testProcessWithNotUniqueArrayItems(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['required' => $this->keyword], $identifier);
        $items = [new JsonString('a', new JsonPointer('0')), new JsonString('a', new JsonPointer('1'))];

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['required' => new JsonArray($items, new JsonPointer())], $context);
    }
}
