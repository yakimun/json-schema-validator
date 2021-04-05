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
     * @var JsonPointer
     */
    private $jsonPointer;

    /**
     * @var JsonTrue
     */
    private $jsonTrue;

    protected function setUp(): void
    {
        $this->jsonPointer = new JsonPointer();
        $this->jsonTrue = new JsonTrue($this->jsonPointer->addToken('a'));
    }

    public function testGetPath(): void
    {
        $this->assertEquals($this->jsonPointer->addToken('a'), $this->jsonTrue->getPath());
    }

    public function testEquals(): void
    {
        $path = $this->jsonPointer->addToken('b');

        $this->assertTrue($this->jsonTrue->equals(new JsonTrue($path)));
        $this->assertFalse($this->jsonTrue->equals(new JsonNull($path)));
    }
}
