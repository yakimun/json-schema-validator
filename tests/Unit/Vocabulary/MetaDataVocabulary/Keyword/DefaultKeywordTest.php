<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DefaultKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DefaultKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\Keyword\DefaultKeyword
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DefaultKeywordValidator
 */
final class DefaultKeywordTest extends TestCase
{
    /**
     * @var DefaultKeyword
     */
    private DefaultKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new DefaultKeyword();

        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['default' => $this->keyword]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $pointer, [$identifier]);
    }

    public function testProcess(): void
    {
        $expected = [new DefaultKeywordValidator(null)];
        $this->keyword->process(['default' => null], $this->context);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
    }
}
