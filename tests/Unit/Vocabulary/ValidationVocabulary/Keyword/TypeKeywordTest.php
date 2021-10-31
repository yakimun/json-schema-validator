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
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\TypeKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ArrayTypeKeywordValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\TypeKeyword
 * @uses \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaProcessor
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ArrayTypeKeywordValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator
 */
final class TypeKeywordTest extends TestCase
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
     * @var TypeKeyword
     */
    private TypeKeyword $keyword;

    /**
     * @var SchemaProcessor
     */
    private SchemaProcessor $processor;

    protected function setUp(): void
    {
        $this->pointer = new JsonPointer();
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), $this->pointer, $this->pointer);
        $this->keyword = new TypeKeyword();
        $this->processor = new SchemaProcessor(['type' => $this->keyword]);
    }

    /**
     * @param 'null'|'boolean'|'object'|'array'|'number'|'string'|'integer' $value
     * @dataProvider stringTypeProvider
     */
    public function testProcessWithStringValue(string $value): void
    {
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);
        $expected = [new StringTypeKeywordValidator($value)];
        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context->getKeywordValidators());
    }

    /**
     * @return non-empty-list<array{'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'}>
     */
    public function stringTypeProvider(): array
    {
        return [
            ['null'],
            ['boolean'],
            ['object'],
            ['array'],
            ['number'],
            ['string'],
            ['integer'],
        ];
    }

    /**
     * @param list<'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'> $value
     * @dataProvider arrayTypeProvider
     */
    public function testProcessWithArrayValue(array $value): void
    {
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);
        $expected = [new ArrayTypeKeywordValidator($value)];
        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context->getKeywordValidators());
    }

    /**
     * @return non-empty-list<array{list<'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'>}>
     */
    public function arrayTypeProvider(): array
    {
        return [
            [['null']],
            [['boolean']],
            [['object']],
            [['array']],
            [['number']],
            [['string']],
            [['integer']],
            [['null', 'boolean']],
        ];
    }

    public function testProcessWithInvalidValue(): void
    {
        $value = null;
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    public function testProcessWithInvalidStringType(): void
    {
        $value = 'a';
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    public function testProcessWithInvalidArrayItem(): void
    {
        $value = [null];
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    public function testProcessWithInvalidArrayItemType(): void
    {
        $value = ['a'];
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    public function testProcessWithNotUniqueArrayItems(): void
    {
        $value = ['null', 'null'];
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }
}
