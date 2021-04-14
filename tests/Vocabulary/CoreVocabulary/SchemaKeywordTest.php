<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaFactory;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\SchemaKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\SchemaKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaFactory
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 */
final class SchemaKeywordTest extends TestCase
{
    /**
     * @var SchemaKeyword
     */
    private $keyword;

    protected function setUp(): void
    {
        $this->keyword = new SchemaKeyword();
    }

    public function testGetName(): void
    {
        $this->assertEquals('$schema', $this->keyword->getName());
    }

    /**
     * @param non-empty-array<string, JsonString> $properties
     *
     * @dataProvider valueProvider
     */
    public function testProcess(array $properties): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['$schema' => $this->keyword]), $identifier);
        $expectedContext = new SchemaContext(new SchemaFactory(['$schema' => $this->keyword]), $identifier);
        $this->keyword->process($properties, $context);

        $this->assertEquals($expectedContext, $context);
    }

    /**
     * @return non-empty-list<array{non-empty-array<string, JsonString>}>
     */
    public function valueProvider(): array
    {
        return [
            [['$schema' => new JsonString('https://example.org/foo', new JsonPointer('$schema'))]],
            [[
                '$schema' => new JsonString('https://example.org/foo', new JsonPointer('foo', '$schema')),
                '$id' => new JsonString('foo', new JsonPointer('foo', '$id')),
            ]],
        ];
    }

    /**
     * @param JsonNull|JsonString $value
     *
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(JsonValue $value): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $context = new SchemaContext(new SchemaFactory(['$schema' => $this->keyword]), $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['$schema' => $value], $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonString}>
     */
    public function invalidValueProvider(): array
    {
        $path = new JsonPointer('$schema');

        return [
            [new JsonNull($path)],
            [new JsonString('/foo', $path)],
            [new JsonString('https://example.com/foo/../bar', $path)],
            [new JsonString('https://example.com/foo', new JsonPointer('foo', '$schema'))],
        ];
    }
}
