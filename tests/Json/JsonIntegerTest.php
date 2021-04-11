<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonInteger;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonInteger
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 */
final class JsonIntegerTest extends TestCase
{
    /**
     * @var JsonInteger
     */
    private $value;

    protected function setUp(): void
    {
        $this->value = new JsonInteger(1, new JsonPointer('a'));
    }

    public function testGetValue(): void
    {
        $this->assertEquals(1, $this->value->getValue());
    }

    public function testGetPath(): void
    {
        $this->assertEquals(new JsonPointer('a'), $this->value->getPath());
    }

    public function testEquals(): void
    {
        $path = new JsonPointer('b');

        $this->assertTrue($this->value->equals(new JsonInteger(1, $path)));
        $this->assertFalse($this->value->equals(new JsonInteger(2, $path)));
        $this->assertFalse($this->value->equals(new JsonNull($path)));
    }
}
