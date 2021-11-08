<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonString;
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
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
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
        $this->pointer = new JsonPointer([]);
        $this->identifier = new SchemaIdentifier(new Uri('https://example.com'), $this->pointer, $this->pointer);
        $this->keyword = new TypeKeyword();
        $this->processor = new SchemaProcessor(['type' => $this->keyword]);
    }

    /**
     * @param 'null'|'boolean'|'object'|'array'|'number'|'string'|'integer' $type
     * @dataProvider stringTypeProvider
     */
    public function testProcessWithStringValue(string $type): void
    {
        $value = new JsonString($type);
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);
        $expected = [new StringTypeKeywordValidator($type)];
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
     * @param non-empty-list<'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'> $types
     * @dataProvider arrayTypeProvider
     */
    public function testProcessWithArrayValue(array $types): void
    {
        $elements = [];

        foreach ($types as $type) {
            $elements[] = new JsonString($type);
        }

        $value = new JsonArray($elements);
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);
        $expected = [new ArrayTypeKeywordValidator($types)];
        $this->keyword->process($value, $context);

        $this->assertEquals($expected, $context->getKeywordValidators());
    }

    /**
     * @return non-empty-list<array{non-empty-list<'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'>}>
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
        $value = new JsonNull();
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    public function testProcessWithInvalidStringType(): void
    {
        $value = new JsonString('a');
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    public function testProcessWithInvalidArrayItem(): void
    {
        $value = new JsonArray([new JsonNull()]);
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    public function testProcessWithInvalidArrayItemType(): void
    {
        $value = new JsonArray([new JsonString('a')]);
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }

    public function testProcessWithNotUniqueArrayItems(): void
    {
        $value = new JsonArray([new JsonString('null'), new JsonString('null')]);
        $context = new SchemaContext($this->processor, ['type' => $value], $this->pointer, $this->identifier, []);

        $this->expectException(SchemaException::class);

        $this->keyword->process($value, $context);
    }
}
