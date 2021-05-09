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
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['type' => $this->keyword], $identifier);
        $keywordHandler = new StringTypeKeywordHandler('https://example.com#/type', $type);
        $this->keyword->process(['type' => new JsonString($type, new JsonPointer('type'))], $context);

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
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['type' => $this->keyword], $identifier);
        $keywordHandler = new ArrayTypeKeywordHandler('https://example.com#/type', $types);

        $items = [];

        foreach ($types as $index => $type) {
            $items[] = new JsonString($type, new JsonPointer('type', (string)$index));
        }

        $this->keyword->process(['type' => new JsonArray($items, new JsonPointer('type'))], $context);

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
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['type' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['type' => new JsonNull(new JsonPointer('type'))], $context);
    }

    public function testProcessWithInvalidStringType(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['type' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['type' => new JsonString('a', new JsonPointer('type'))], $context);
    }

    public function testProcessWithInvalidArrayItem(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['type' => $this->keyword], $identifier);
        $properties = ['type' => new JsonArray([new JsonNull(new JsonPointer('type', '0'))], new JsonPointer('type'))];

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process($properties, $context);
    }

    public function testProcessWithNotUniqueArrayItems(): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(['type' => $this->keyword], $identifier);
        $items = [
            new JsonString('null', new JsonPointer('type', '0')),
            new JsonString('null', new JsonPointer('type', '1')),
        ];

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['type' => new JsonArray($items, new JsonPointer('type'))], $context);
    }
}
