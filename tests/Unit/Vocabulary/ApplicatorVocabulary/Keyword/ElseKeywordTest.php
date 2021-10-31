<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\Keyword;

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
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ElseKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ElseKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword\ElseKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ElseKeywordValidator
 */
final class ElseKeywordTest extends TestCase
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var JsonPointer
     */
    private JsonPointer $pointer;

    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var ElseKeyword
     */
    private ElseKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->uri = new Uri('https://example.com');
        $this->pointer = new JsonPointer();
        $this->identifier = new SchemaIdentifier($this->uri, $this->pointer, $this->pointer);
        $this->keyword = new ElseKeyword();
        $this->processor = new SchemaProcessor(['else' => $this->keyword]);
    }

    public function testProcess(): void
    {
        $value = (object)[];
        $context = new SchemaContext(
            $this->processor,
            ['if' => (object)[], 'else' => $value],
            $this->pointer,
            $this->identifier,
            [],
        );
        $pointer = $this->pointer->addTokens('else');
        $identifier = new SchemaIdentifier($this->uri, $pointer, $pointer);
        $validator = new ObjectSchemaValidator($this->uri, $pointer, []);
        $expectedKeywordValidators = [new ElseKeywordValidator($validator)];
        $expectedProcessedSchemas = [new ProcessedSchema($validator, $identifier, [], [], [])];
        $this->keyword->process($value, $context);

        $this->assertEquals($expectedKeywordValidators, $context->getKeywordValidators());
        $this->assertEquals($expectedProcessedSchemas, $context->getProcessedSchemas());
    }

    public function testProcessWithoutIf(): void
    {
        $value = (object)[];
        $context = new SchemaContext($this->processor, ['else' => $value], $this->pointer, $this->identifier, []);
        $pointer = $this->pointer->addTokens('else');
        $identifier = new SchemaIdentifier($this->uri, $pointer, $pointer);
        $validator = new ObjectSchemaValidator($this->uri, $pointer, []);
        $expectedProcessedSchemas = [new ProcessedSchema($validator, $identifier, [], [], [])];
        $this->keyword->process($value, $context);

        $this->assertEmpty($context->getKeywordValidators());
        $this->assertEquals($expectedProcessedSchemas, $context->getProcessedSchemas());
    }

    public function testProcessWithInvalidValue(): void
    {
        $value = null;
        $context = new SchemaContext($this->processor, ['else' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }
}
