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
     * @var TypeKeyword
     */
    private TypeKeyword $keyword;

    /**
     * @var SchemaContext
     */
    private SchemaContext $context;

    protected function setUp(): void
    {
        $this->keyword = new TypeKeyword();

        $uri = new Uri('https://example.com');
        $pointer = new JsonPointer();
        $processor = new SchemaProcessor(['type' => $this->keyword]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        $this->context = new SchemaContext($processor, $pointer, [$identifier]);
    }

    /**
     * @param 'null'|'boolean'|'object'|'array'|'number'|'string'|'integer' $value
     * @dataProvider stringTypeProvider
     */
    public function testProcessWithStringValue(string $value): void
    {
        $expected = [new StringTypeKeywordValidator($value)];
        $this->keyword->process(['type' => $value], $this->context);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
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
        $expected = [new ArrayTypeKeywordValidator($value)];
        $this->keyword->process(['type' => $value], $this->context);

        $this->assertEquals($expected, $this->context->getKeywordValidators());
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
        $this->expectException(SchemaException::class);

        $this->keyword->process(['type' => null], $this->context);
    }

    public function testProcessWithInvalidStringType(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['type' => 'a'], $this->context);
    }

    public function testProcessWithInvalidArrayItem(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['type' => [null]], $this->context);
    }

    public function testProcessWithInvalidArrayItemType(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['type' => ['a']], $this->context);
    }

    public function testProcessWithNotUniqueArrayItems(): void
    {
        $this->expectException(SchemaException::class);

        $this->keyword->process(['type' => ['null', 'null']], $this->context);
    }
}
