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
     * @var JsonPointer
     */
    private $jsonPointer;

    /**
     * @var JsonFalse
     */
    private $jsonFalse;

    protected function setUp(): void
    {
        $this->jsonPointer = new JsonPointer();
        $this->jsonFalse = new JsonFalse($this->jsonPointer->addToken('a'));
    }

    public function testGetPath(): void
    {
        $this->assertEquals($this->jsonPointer->addToken('a'), $this->jsonFalse->getPath());
    }

    public function testEquals(): void
    {
        $path = $this->jsonPointer->addToken('b');

        $this->assertTrue($this->jsonFalse->equals(new JsonFalse($path)));
        $this->assertFalse($this->jsonFalse->equals(new JsonNull($path)));
    }
}
