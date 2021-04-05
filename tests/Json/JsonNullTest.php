<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonTrue
 */
final class JsonNullTest extends TestCase
{
    /**
     * @var JsonPointer
     */
    private $jsonPointer;

    /**
     * @var JsonNull
     */
    private $jsonNull;

    protected function setUp(): void
    {
        $this->jsonPointer = new JsonPointer();
        $this->jsonNull = new JsonNull($this->jsonPointer->addToken('a'));
    }

    public function testGetPath(): void
    {
        $this->assertEquals($this->jsonPointer->addToken('a'), $this->jsonNull->getPath());
    }

    public function testEquals(): void
    {
        $path = $this->jsonPointer->addToken('b');

        $this->assertTrue($this->jsonNull->equals(new JsonNull($path)));
        $this->assertFalse($this->jsonNull->equals(new JsonTrue($path)));
    }
}
