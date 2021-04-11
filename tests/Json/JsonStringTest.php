<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonString;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonString
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 */
final class JsonStringTest extends TestCase
{
    /**
     * @var JsonString
     */
    private $value;

    protected function setUp(): void
    {
        $this->value = new JsonString('foo', new JsonPointer('a'));
    }

    public function testGetValue(): void
    {
        $this->assertEquals('foo', $this->value->getValue());
    }

    public function testGetPath(): void
    {
        $this->assertEquals(new JsonPointer('a'), $this->value->getPath());
    }

    public function testEquals(): void
    {
        $path = new JsonPointer('b');

        $this->assertTrue($this->value->equals(new JsonString('foo', $path)));
        $this->assertFalse($this->value->equals(new JsonString('bar', $path)));
        $this->assertFalse($this->value->equals(new JsonNull($path)));
    }
}
