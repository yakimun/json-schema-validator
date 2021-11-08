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
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 */
final class JsonBooleanTest extends TestCase
{
    /**
     * @var bool
     */
    private bool $value;

    /**
     * @var JsonBoolean
     */
    private JsonBoolean $boolean;

    protected function setUp(): void
    {
        $this->value = true;
        $this->boolean = new JsonBoolean($this->value);
    }

    public function testGetValue(): void
    {
        $expected = $this->value;

        $this->assertSame($expected, $this->boolean->getValue());
    }

    /**
     * @param JsonValue $value
     * @param bool $expected
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertSame($expected, $this->boolean->equals($value));
    }

    /**
     * @return non-empty-list<array{JsonValue, bool}>
     */
    public function valueProvider(): array
    {
        return [
            [new JsonBoolean(true), true],
            [new JsonBoolean(false), false],
            [new JsonNull(), false],
            [new JsonObject([]), false],
            [new JsonArray([]), false],
            [new JsonInteger(1), false],
            [new JsonFloat(1.0), false],
            [new JsonString('a'), false],
        ];
    }
}
