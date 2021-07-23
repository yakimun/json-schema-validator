<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\UnevaluatedVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword\UnevaluatedItemsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordValidator\UnevaluatedItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\Keyword\UnevaluatedItemsKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordValidator\UnevaluatedItemsKeywordValidator
 */
final class UnevaluatedItemsKeywordTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var UnevaluatedItemsKeyword
     */
    private UnevaluatedItemsKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->keyword = new UnevaluatedItemsKeyword();

        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['unevaluatedItems' => $this->keyword]);
        $identifier = new SchemaIdentifier($this->uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $pointer, [$identifier]);
    }

    public function testGetName(): void
    {
        $this->assertSame('unevaluatedItems', $this->keyword->getName());
    }

    public function testProcess(): void
    {
        $pointer = new JsonPointer('unevaluatedItems');
        $identifier = new SchemaIdentifier($this->uri, $pointer, $pointer);
        $validator = new ObjectSchemaValidator($this->uri, $pointer, []);
        $expectedKeywordValidators = [new UnevaluatedItemsKeywordValidator($validator)];
        $expectedProcessedSchemas = [new ProcessedSchema($validator, [$identifier], [], [])];
        $this->keyword->process(['unevaluatedItems' => (object)[]], $this->context);

        $this->assertEquals($expectedKeywordValidators, $this->context->getKeywordValidators());
        $this->assertEquals($expectedProcessedSchemas, $this->context->getProcessedSchemas());
    }

    public function testProcessWithInvalidValue(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['unevaluatedItems' => null], $this->context);
    }
}
