<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonFloat
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 */
final class JsonFloatTest extends TestCase
{
    /**
     * @var JsonFloat
     */
    private $value;

    protected function setUp(): void
    {
        $this->value = new JsonFloat(1.5, new JsonPointer('a'));
    }

    public function testGetValue(): void
    {
        $this->assertEquals(1.5, $this->value->getValue());
    }

    public function testGetPath(): void
    {
        $this->assertEquals(new JsonPointer('a'), $this->value->getPath());
    }

    public function testEquals(): void
    {
        $path = new JsonPointer('b');

        $this->assertTrue($this->value->equals(new JsonFloat(1.5, $path)));
        $this->assertFalse($this->value->equals(new JsonFloat(2.5, $path)));
        $this->assertFalse($this->value->equals(new JsonNull($path)));
    }
}
