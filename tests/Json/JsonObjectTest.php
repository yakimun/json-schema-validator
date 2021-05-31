<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaContext
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordHandler
 */
final class JsonObjectTest extends TestCase
{
    /**
     * @var JsonObject
     */
    private $value;

    protected function setUp(): void
    {
        $this->value = new JsonObject(['a' => new JsonNull(), 'b' => new JsonBoolean(true)]);
    }

    public function testGetProperties(): void
    {
        $this->assertEquals(['a' => new JsonNull(), 'b' => new JsonBoolean(true)], $this->value->getProperties());
    }

    /**
     * @param JsonObject|JsonNull $value
     * @param bool $expected
     *
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertEquals($expected, $this->value->equals($value));
    }

    /**
     * @return non-empty-list<array{JsonObject|JsonNull, bool}>
     */
    public function valueProvider(): array
    {
        $jsonNull = new JsonNull();
        $jsonBoolean = new JsonBoolean(true);

        return [
            [new JsonObject(['a' => $jsonNull, 'b' => $jsonBoolean]), true],
            [new JsonObject(['b' => $jsonBoolean, 'a' => $jsonNull]), true],
            [new JsonObject([]), false],
            [new JsonObject(['a' => $jsonNull]), false],
            [new JsonObject(['a' => $jsonBoolean, 'b' => $jsonNull]), false],
            [new JsonObject(['a' => $jsonNull, 'b' => $jsonBoolean, 'c' => $jsonNull]), false],
            [new JsonNull(), false],
        ];
    }

    public function testProcessAsSchemaWithEmptyValue(): void
    {
        $keyword = $this->createMock(Keyword::class);
        $keyword
            ->expects($this->never())
            ->method('process');

        $value = new JsonObject([]);
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $validator = new ObjectSchemaValidator('https://example.com', []);
        $processedSchema = new ProcessedSchema($validator, $identifier, [], [], $pointer);

        $this->assertEquals([$processedSchema], $value->processAsSchema($identifier, ['a' => $keyword], $pointer));
    }

    public function testProcessAsSchemaWithKnownKeyword(): void
    {
        $properties = ['a' => new JsonNull()];
        $pointer = new JsonPointer();

        $keyword = $this->createMock(Keyword::class);
        $keyword
            ->expects($this->once())
            ->method('process')
            ->with(
                $this->equalTo($properties),
                $this->equalTo($pointer),
                $this->anything(),
            );

        $value = new JsonObject($properties);
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $validator = new ObjectSchemaValidator('https://example.com', []);
        $processedSchema = new ProcessedSchema($validator, $identifier, [], [], $pointer);

        $this->assertEquals([$processedSchema], $value->processAsSchema($identifier, ['a' => $keyword], $pointer));
    }

    public function testProcessAsSchemaWithUnknownKeyword(): void
    {
        $properties = ['a' => new JsonNull()];

        $keyword = $this->createMock(Keyword::class);
        $keyword
            ->expects($this->never())
            ->method('process');

        $value = new JsonObject($properties);
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $keywordHandler = new UnknownKeywordHandler('https://example.com#/a', 'a', $properties['a']);
        $validator = new ObjectSchemaValidator('https://example.com', [$keywordHandler]);
        $processedSchema = new ProcessedSchema($validator, $identifier, [], [], $pointer);

        $this->assertEquals([$processedSchema], $value->processAsSchema($identifier, ['b' => $keyword], $pointer));
    }
}
