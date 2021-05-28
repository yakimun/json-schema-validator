<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\MetaDataVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DefaultKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\DefaultKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DefaultKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler\DefaultKeywordHandler
 */
final class DefaultKeywordTest extends TestCase
{
    /**
     * @var DefaultKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new DefaultKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('default', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['default' => $this->keyword], $identifier);
        $value = new JsonNull();
        $keywordHandler = new DefaultKeywordHandler('https://example.com#/default', $value);
        $this->keyword->process(['default' => $value], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
    }
}
