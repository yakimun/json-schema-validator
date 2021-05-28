<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\InvalidSchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonFloat;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonFloat
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 */
final class JsonFloatTest extends TestCase
{
    /**
     * @var JsonFloat
     */
    private $value;

    protected function setUp(): void
    {
        $this->value = new JsonFloat(1.5);
    }

    public function testGetValue(): void
    {
        $this->assertEquals(1.5, $this->value->getValue());
    }

    public function testEquals(): void
    {
        $this->assertTrue($this->value->equals(new JsonFloat(1.5)));
        $this->assertFalse($this->value->equals(new JsonFloat(2.5)));
        $this->assertFalse($this->value->equals(new JsonNull()));
    }

    public function testProcessAsSchema(): void
    {
        $pointer = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $keywords = ['a' => $this->createStub(Keyword::class)];

        $this->expectException(InvalidSchemaException::class);

        /**
         * @psalm-suppress UnusedMethodCall
         */
        $this->value->processAsSchema($identifier, $keywords, $pointer);
    }
}
