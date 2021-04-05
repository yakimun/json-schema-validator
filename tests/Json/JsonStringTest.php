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
    private $jsonString;

    protected function setUp(): void
    {
        $jsonPointer = new JsonPointer();

        $this->jsonString = new JsonString('foo', $jsonPointer->addToken('a'));
    }

    public function testGetValue(): void
    {
        $this->assertEquals('foo', $this->jsonString->getValue());
    }

    public function testGetPath(): void
    {
        $jsonPointer = new JsonPointer();

        $this->assertEquals($jsonPointer->addToken('a'), $this->jsonString->getPath());
    }

    public function testEquals(): void
    {
        $jsonPointer = new JsonPointer();
        $path = $jsonPointer->addToken('b');

        $this->assertTrue($this->jsonString->equals(new JsonString('foo', $path)));
        $this->assertFalse($this->jsonString->equals(new JsonString('bar', $path)));
        $this->assertFalse($this->jsonString->equals(new JsonNull($path)));
    }
}
