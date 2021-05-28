<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary\Keyword;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\SchemaKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\SchemaKeyword
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
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
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['$schema' => $this->keyword], $identifier);
        $expectedContext = new SchemaContext(['$schema' => $this->keyword], $identifier);
        $this->keyword->process($properties, $pointer, $context);

        $this->assertEquals($expectedContext, $context);
    }

    /**
     * @return non-empty-list<array{non-empty-array<string, JsonString>}>
     */
    public function valueProvider(): array
    {
        return [
            [['$schema' => new JsonString('https://example.org/foo')]],
            [['$schema' => new JsonString('https://example.org/foo'), '$id' => new JsonString('foo')]],
        ];
    }

    /**
     * @param JsonNull|JsonString $value
     * @param JsonPointer $pointer
     *
     * @dataProvider invalidValueProvider
     */
    public function testProcessWithInvalidValue(JsonValue $value, JsonPointer $pointer): void
    {
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $context = new SchemaContext(['$schema' => $this->keyword], $identifier);

        $this->expectException(InvalidSchemaException::class);

        $this->keyword->process(['$schema' => $value], $pointer, $context);
    }

    /**
     * @return non-empty-list<array{JsonNull|JsonString, JsonPointer}>
     */
    public function invalidValueProvider(): array
    {
        $pointer = new JsonPointer();

        return [
            [new JsonNull(), $pointer],
            [new JsonString('/foo'), $pointer],
            [new JsonString('https://example.com/foo/../bar'), $pointer],
            [new JsonString('https://example.com/foo'), new JsonPointer('foo')],
        ];
    }
}
