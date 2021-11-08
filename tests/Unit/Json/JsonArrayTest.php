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
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonArray
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 */
final class JsonArrayTest extends TestCase
{
    /**
     * @var JsonValue
     */
    private JsonValue $element;

    /**
     * @var JsonArray
     */
    private JsonArray $array;

    protected function setUp(): void
    {
        $this->element = new JsonNull();
        $this->array = new JsonArray([$this->element]);
    }

    public function testGetValue(): void
    {
        $expected = [$this->element];

        $this->assertSame($expected, $this->array->getElements());
    }

    /**
     * @param JsonValue $value
     * @param bool $expected
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertSame($expected, $this->array->equals($value));
    }

    /**
     * @return non-empty-list<array{JsonValue, bool}>
     */
    public function valueProvider(): array
    {
        return [
            [new JsonArray([new JsonNull()]), true],
            [new JsonArray([]), false],
            [new JsonArray([new JsonBoolean(true)]), false],
            [new JsonArray([new JsonNull(), new JsonBoolean(true)]), false],
            [new JsonNull(), false],
            [new JsonBoolean(true), false],
            [new JsonObject([]), false],
            [new JsonInteger(1), false],
            [new JsonFloat(1.0), false],
            [new JsonString('a'), false],
        ];
    }
}
