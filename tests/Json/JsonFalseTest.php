<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonFalse;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonFalse
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 */
final class JsonFalseTest extends TestCase
{
    /**
     * @var JsonFalse
     */
    private $value;

    protected function setUp(): void
    {
        $this->value = new JsonFalse(new JsonPointer('a'));
    }

    public function testGetPath(): void
    {
        $this->assertEquals(new JsonPointer('a'), $this->value->getPath());
    }

    public function testEquals(): void
    {
        $path = new JsonPointer('b');

        $this->assertTrue($this->value->equals(new JsonFalse($path)));
        $this->assertFalse($this->value->equals(new JsonNull($path)));
    }
}
