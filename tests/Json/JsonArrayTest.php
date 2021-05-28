<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 */
final class JsonArrayTest extends TestCase
{
    /**
     * @var JsonArray
     */
    private $value;

    protected function setUp(): void
    {
        $this->value = new JsonArray([new JsonNull(), new JsonBoolean(true)]);
    }

    public function testGetItems(): void
    {
        $this->assertEquals([new JsonNull(), new JsonBoolean(true)], $this->value->getItems());
    }

    /**
     * @param JsonArray|JsonNull $value
     * @param bool $expected
     *
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertEquals($expected, $this->value->equals($value));
    }

    /**
     * @return non-empty-list<array{JsonArray|JsonNull, bool}>
     */
    public function valueProvider(): array
    {
        $jsonNull = new JsonNull();
        $jsonBoolean = new JsonBoolean(true);

        return [
            [new JsonArray([$jsonNull, $jsonBoolean]), true],
            [new JsonArray([]), false],
            [new JsonArray([$jsonNull]), false],
            [new JsonArray([$jsonBoolean, $jsonNull]), false],
            [new JsonArray([$jsonNull, $jsonBoolean, $jsonNull]), false],
            [new JsonNull(), false],
        ];
    }

    public function testProcessAsSchema(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $keywords = ['a' => $this->createStub(Keyword::class)];

        $this->expectException(InvalidSchemaException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $this->value->processAsSchema($identifier, $keywords, $pointer);
    }
}
