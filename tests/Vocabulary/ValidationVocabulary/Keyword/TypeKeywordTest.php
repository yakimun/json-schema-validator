<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\TypeKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\ArrayTypeKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\StringTypeKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\Keyword\TypeKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\ArrayTypeKeywordHandler
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordHandler\StringTypeKeywordHandler
 */
final class TypeKeywordTest extends TestCase
{
    /**
     * @var TypeKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new TypeKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('type', $this->keyword->getName());
    }

    /**
     * @param 'null'|'boolean'|'object'|'array'|'number'|'string'|'integer' $type
     *
     * @dataProvider stringTypeProvider
     */
    public function testProcessWithStringValue(string $type): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['type' => $this->keyword], $identifier);
        $keywordHandler = new StringTypeKeywordHandler('https://example.com#/type', $type);
        $this->keyword->process(['type' => new JsonString($type)], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
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
     * @param list<'null'|'boolean'|'object'|'array'|'number'|'string'|'integer'> $types
     *
     * @dataProvider arrayTypeProvider
     */
    public function testProcessWithArrayValue(array $types): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['type' => $this->keyword], $identifier);
        $keywordHandler = new ArrayTypeKeywordHandler('https://example.com#/type', $types);

        $items = [];

        foreach ($types as $type) {
            $items[] = new JsonString($type);
        }

        $this->keyword->process(['type' => new JsonArray($items)], $pointer, $context);

        $this->assertEquals([$keywordHandler], $context->getKeywordHandlers());
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
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['type' => $this->keyword], $identifier);
        $value = new JsonNull();

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['type' => $value], $pointer, $context);
    }

    public function testProcessWithInvalidStringType(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['type' => $this->keyword], $identifier);
        $value = new JsonString('a');

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['type' => $value], $pointer, $context);
    }

    public function testProcessWithInvalidArrayItem(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['type' => $this->keyword], $identifier);
        $value = new JsonArray([new JsonNull()]);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['type' => $value], $pointer, $context);
    }

    public function testProcessWithNotUniqueArrayItems(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['type' => $this->keyword], $identifier);
        $value = new JsonArray([new JsonString('null'), new JsonString('null')]);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['type' => $value], $pointer, $context);
    }
}
