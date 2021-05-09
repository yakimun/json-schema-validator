<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\FormatAssertionVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\Keyword\FormatKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\KeywordHandler\FormatKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\Keyword\FormatKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\FormatAssertionVocabulary\KeywordHandler\FormatKeywordHandler
 */
final class FormatKeywordTest extends TestCase
{
    /**
     * @var FormatKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new FormatKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('format', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $keywordHandler = new FormatKeywordHandler('https://example.com#/format', 'a');
        $context = new SchemaContext(['format' => $this->keyword], $identifier);
        $this->keyword->process(['format' => new JsonString('a', new JsonPointer('format'))], $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    public function testProcessWithInvalidValue(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['format' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['format' => new JsonNull(new JsonPointer('format'))], $context);
    }
}
