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
    private $jsonInteger;

    protected function setUp(): void
    {
        $jsonPointer = new JsonPointer();

        $this->jsonInteger = new JsonInteger(1, $jsonPointer->addToken('a'));
    }

    public function testGetValue(): void
    {
        $this->assertEquals(1, $this->jsonInteger->getValue());
    }

    public function testGetPath(): void
    {
        $jsonPointer = new JsonPointer();

        $this->assertEquals($jsonPointer->addToken('a'), $this->jsonInteger->getPath());
    }

    public function testEquals(): void
    {
        $jsonPointer = new JsonPointer();
        $path = $jsonPointer->addToken('b');

        $this->assertTrue($this->jsonInteger->equals(new JsonInteger(1, $path)));
        $this->assertFalse($this->jsonInteger->equals(new JsonInteger(2, $path)));
        $this->assertFalse($this->jsonInteger->equals(new JsonNull($path)));
    }
}
