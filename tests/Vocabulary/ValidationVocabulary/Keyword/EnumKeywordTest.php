<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\EnumKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\EnumKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\EnumKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\EnumKeywordHandler
 */
final class EnumKeywordTest extends TestCase
{
    /**
     * @var EnumKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new EnumKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('enum', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['enum' => $this->keyword], $identifier);
        $elements = [new JsonNull()];
        $keywordHandler = new EnumKeywordHandler('https://example.com#/enum', $elements);
        $this->keyword->process(['enum' => new JsonArray($elements)], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    public function testProcessWithInvalidValue(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['enum' => $this->keyword], $identifier);
        $value = new JsonNull();

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['enum' => $value], $pointer, $context);
    }
}
