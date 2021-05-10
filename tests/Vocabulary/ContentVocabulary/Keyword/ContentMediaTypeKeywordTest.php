<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ContentVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentMediaTypeKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentMediaTypeKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\Keyword\ContentMediaTypeKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler\ContentMediaTypeKeywordHandler
 */
final class ContentMediaTypeKeywordTest extends TestCase
{
    /**
     * @var ContentMediaTypeKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new ContentMediaTypeKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('contentMediaType', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['contentMediaType' => $this->keyword], $identifier);
        $keywordHandler = new ContentMediaTypeKeywordHandler('https://example.com#/contentMediaType', 'a');
        $properties = ['contentMediaType' => new JsonString('a', new JsonPointer('contentMediaType'))];
        $this->keyword->process($properties, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }

    public function testProcessWithInvalidValue(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['contentMediaType' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['contentMediaType' => new JsonNull(new JsonPointer('contentMediaType'))], $context);
    }
}
