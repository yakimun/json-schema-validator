<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\DependentRequiredKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\DependentRequiredKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\DependentRequiredKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\DependentRequiredKeywordHandler
 */
final class DependentRequiredKeywordTest extends TestCase
{
    /**
     * @var DependentRequiredKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new DependentRequiredKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('dependentRequired', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['dependentRequired' => $this->keyword], $identifier);
        $keywordHandler = new DependentRequiredKeywordHandler('https://example.com#/dependentRequired', ['a' => ['b']]);
        $value = new JsonObject(['a' => new JsonArray([new JsonString('b')])]);
        $this->keyword->process(['dependentRequired' => $value], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    public function testProcessWithInvalidValue(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['dependentRequired' => $this->keyword], $identifier);
        $value = new JsonNull();

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['dependentRequired' => $value], $pointer, $context);
    }

    public function testProcessWithInvalidObjectProperty(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['dependentRequired' => $this->keyword], $identifier);
        $value = new JsonObject(['a' => new JsonNull()]);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['dependentRequired' => $value], $pointer, $context);
    }

    public function testProcessWithInvalidArrayItem(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['dependentRequired' => $this->keyword], $identifier);
        $value = new JsonObject(['a' => new JsonArray([new JsonNull()])]);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['dependentRequired' => $value], $pointer, $context);
    }

    public function testProcessWithNotUniqueArrayItems(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['dependentRequired' => $this->keyword], $identifier);
        $value = new JsonObject(['a' => new JsonArray([new JsonString('b'), new JsonString('b')])]);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['dependentRequired' => $value], $pointer, $context);
    }
}
