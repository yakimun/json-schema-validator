<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonArray;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonString;
use Yakimun\JsonSchemaValidator\Json\JsonValue;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 */
final class JsonObjectTest extends TestCase
{
    /**
     * @var string
     */
    private string $key1;

    /**
     * @var string
     */
    private string $key2;

    /**
     * @var JsonValue
     */
    private JsonValue $property1;

    /**
     * @var JsonValue
     */
    private JsonValue $property2;

    /**
     * @var JsonObject
     */
    private JsonObject $object;

    protected function setUp(): void
    {
        $this->key1 = 'a';
        $this->key2 = 'b';
        $this->property1 = new JsonNull();
        $this->property2 = new JsonBoolean(true);
        $this->object = new JsonObject([$this->key1 => $this->property1, $this->key2 => $this->property2]);
    }

    public function testGetValue(): void
    {
        $expected = [$this->key1 => $this->property1, $this->key2 => $this->property2];

        $this->assertSame($expected, $this->object->getProperties());
    }

    /**
     * @param JsonValue $value
     * @param bool $expected
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertSame($expected, $this->object->equals($value));
    }

    /**
     * @return non-empty-list<array{JsonValue, bool}>
     */
    public function valueProvider(): array
    {
        return [
            [new JsonObject(['a' => new JsonNull(), 'b' => new JsonBoolean(true)]), true],
            [new JsonObject(['b' => new JsonBoolean(true), 'a' => new JsonNull()]), true],
            [new JsonObject([]), false],
            [new JsonObject(['a' => new JsonNull(), 'b' => new JsonNull()]), false],
            [new JsonObject(['a' => new JsonNull(), 'b' => new JsonBoolean(true), 'c' => new JsonNull()]), false],
            [new JsonNull(), false],
            [new JsonBoolean(true), false],
            [new JsonArray([]), false],
            [new JsonInteger(1), false],
            [new JsonFloat(1.0), false],
            [new JsonString('a'), false],
        ];
    }
}
