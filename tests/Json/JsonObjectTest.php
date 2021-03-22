<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\Json\JsonValue;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonObject
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonTrue
 */
final class JsonObjectTest extends TestCase
{
    /**
     * @var JsonObject
     */
    private $jsonObject;

    protected function setUp(): void
    {
        $path = new JsonPointer('a');

        $this->jsonObject = new JsonObject(['a' => new JsonNull($path), 'b' => new JsonTrue($path)], $path);
    }

    public function testGetProperties(): void
    {
        $properties = $this->jsonObject->getProperties();

        $this->assertCount(2, $properties);
        $this->assertInstanceOf(JsonNull::class, $properties['a']);
        $this->assertInstanceOf(JsonTrue::class, $properties['b']);
    }

    public function testGetPath(): void
    {
        $this->assertEquals('/a', $this->jsonObject->getPath());
    }

    /**
     * @param JsonValue $value
     * @param bool $expected
     *
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertEquals($expected, $this->jsonObject->equals($value));
    }

    /**
     * @return list<array{JsonValue, bool}>
     */
    public function valueProvider(): array
    {
        $path = new JsonPointer('b');

        $jsonNull = new JsonNull($path);
        $jsonTrue = new JsonTrue($path);

        return [
            [new JsonObject(['a' => $jsonNull, 'b' => $jsonTrue], $path), true],
            [new JsonObject(['b' => $jsonTrue, 'a' => $jsonNull], $path), true],
            [new JsonObject([], $path), false],
            [new JsonObject(['a' => $jsonNull], $path), false],
            [new JsonObject(['a' => $jsonTrue, 'b' => $jsonNull], $path), false],
            [new JsonObject(['a' => $jsonNull, 'b' => $jsonTrue, 'c' => $jsonNull], $path), false],
            [new JsonNull($path), false],
        ];
    }
}
