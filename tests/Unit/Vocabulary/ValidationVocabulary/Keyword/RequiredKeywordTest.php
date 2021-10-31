<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaProcessor;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\RequiredKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\RequiredKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\RequiredKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\RequiredKeywordValidator
 */
final class RequiredKeywordTest extends TestCase
{
    /**
     * @var JsonPointer
     */
    private JsonPointer $pointer;

    /**
     * @var SchemaIdentifier
     */
    private SchemaIdentifier $identifier;

    /**
     * @var RequiredKeyword
     */
    private RequiredKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->pointer = new JsonPointer();
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), $this->pointer, $this->pointer);
        $this->keyword = new RequiredKeyword();
        $this->processor = new SchemaProcessor(['required' => $this->keyword]);
    }

    public function testProcess(): void
    {
        $value = ['a'];
        $context = new SchemaContext($this->processor, ['required' => $value], $this->pointer, $this->identifier, []);
        $expected = [new RequiredKeywordValidator($value)];
        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context->getKeywordValidators());
    }

    public function testProcessWithInvalidValue(): void
    {
        $value = null;
        $context = new SchemaContext($this->processor, ['required' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    public function testProcessWithInvalidArrayItem(): void
    {
        $value = [null];
        $context = new SchemaContext($this->processor, ['required' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    public function testProcessWithNotUniqueArrayItems(): void
    {
        $value = ['a', 'a'];
        $context = new SchemaContext($this->processor, ['required' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }
}
