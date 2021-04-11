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
    private $value;

    protected function setUp(): void
    {
        $properties = ['a' => new JsonNull(new JsonPointer('a', 'a')), 'b' => new JsonTrue(new JsonPointer('a', 'b'))];

        $this->value = new JsonObject($properties, new JsonPointer('a'));
    }

    public function testGetProperties(): void
    {
        $properties = ['a' => new JsonNull(new JsonPointer('a', 'a')), 'b' => new JsonTrue(new JsonPointer('a', 'b'))];

        $this->assertEquals($properties, $this->value->getProperties());
    }

    public function testGetPath(): void
    {
        $this->assertEquals(new JsonPointer('a'), $this->value->getPath());
    }

    /**
     * @param JsonValue $value
     * @param bool $expected
     *
     * @dataProvider valueProvider
     */
    public function testEquals(JsonValue $value, bool $expected): void
    {
        $this->assertEquals($expected, $this->value->equals($value));
    }

    /**
     * @return non-empty-list<array{JsonValue, bool}>
     */
    public function valueProvider(): array
    {
        $path = new JsonPointer('b');
        $jsonNull = new JsonNull(new JsonPointer('b', 'a'));
        $jsonTrue = new JsonTrue(new JsonPointer('b', 'b'));

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
