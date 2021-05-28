<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\MetaDataVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\WriteOnlyKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\WriteOnlyKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\WriteOnlyKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\WriteOnlyKeywordHandler
 */
final class WriteOnlyKeywordTest extends TestCase
{
    /**
     * @var WriteOnlyKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new WriteOnlyKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('writeOnly', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['writeOnly' => $this->keyword], $identifier);
        $keywordHandler = new WriteOnlyKeywordHandler('https://example.com#/writeOnly', true);
        $this->keyword->process(['writeOnly' => new JsonBoolean(true)], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    public function testProcessWithInvalidValue(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['writeOnly' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['writeOnly' => new JsonNull()], $pointer, $context);
    }
}
