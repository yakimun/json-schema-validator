<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonTrue
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 */
final class JsonTrueTest extends TestCase
{
    /**
     * @var JsonTrue
     */
    private $jsonTrue;

    protected function setUp(): void
    {
        $this->jsonTrue = new JsonTrue(new JsonPointer('a'));
    }

    public function testGetPath(): void
    {
        $this->assertEquals('/a', $this->jsonTrue->getPath());
    }

    public function testEquals(): void
    {
        $path = new JsonPointer('b');

        $this->assertTrue($this->jsonTrue->equals(new JsonTrue($path)));
        $this->assertFalse($this->jsonTrue->equals(new JsonNull($path)));
    }
}
