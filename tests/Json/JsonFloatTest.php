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
    private $jsonFloat;

    protected function setUp(): void
    {
        $jsonPointer = new JsonPointer();

        $this->jsonFloat = new JsonFloat(1.5, $jsonPointer->addToken('a'));
    }

    public function testGetValue(): void
    {
        $this->assertEquals(1.5, $this->jsonFloat->getValue());
    }

    public function testGetPath(): void
    {
        $jsonPointer = new JsonPointer();

        $this->assertEquals($jsonPointer->addToken('a'), $this->jsonFloat->getPath());
    }

    public function testEquals(): void
    {
        $jsonPointer = new JsonPointer();
        $path = $jsonPointer->addToken('b');

        $this->assertTrue($this->jsonFloat->equals(new JsonFloat(1.5, $path)));
        $this->assertFalse($this->jsonFloat->equals(new JsonFloat(2.5, $path)));
        $this->assertFalse($this->jsonFloat->equals(new JsonNull($path)));
    }
}
