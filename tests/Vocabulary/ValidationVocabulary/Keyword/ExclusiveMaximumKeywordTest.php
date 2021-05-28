<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ExclusiveMaximumKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatExclusiveMaximumKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerExclusiveMaximumKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\ExclusiveMaximumKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFloat
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\FloatExclusiveMaximumKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\IntegerExclusiveMaximumKeywordHandler
 */
final class ExclusiveMaximumKeywordTest extends TestCase
{
    /**
     * @var ExclusiveMaximumKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new ExclusiveMaximumKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('exclusiveMaximum', $this->keyword->getName());
    }

    public function testProcessWithIntegerValue(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['exclusiveMaximum' => $this->keyword], $identifier);
        $keywordHandler = new IntegerExclusiveMaximumKeywordHandler('https://example.com#/exclusiveMaximum', 1);
        $this->keyword->process(['exclusiveMaximum' => new JsonInteger(1)], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    public function testProcessWithFloatValue(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['exclusiveMaximum' => $this->keyword], $identifier);
        $keywordHandler = new FloatExclusiveMaximumKeywordHandler('https://example.com#/exclusiveMaximum', 1.5);
        $this->keyword->process(['exclusiveMaximum' => new JsonFloat(1.5)], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    public function testProcessWithInvalidValue(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['exclusiveMaximum' => $this->keyword], $identifier);
        $value = new JsonNull();

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['exclusiveMaximum' => $value], $pointer, $context);
    }
}
