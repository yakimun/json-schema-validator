<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonBoolean
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator
 */
final class JsonBooleanTest extends TestCase
{
    /**
     * @var JsonBoolean
     */
    private $value;

    protected function setUp(): void
    {
        $this->value = new JsonBoolean(true);
    }

    public function testGetValue(): void
    {
        $this->assertEquals(true, $this->value->getValue());
    }

    public function testEquals(): void
    {
        $this->assertTrue($this->value->equals(new JsonBoolean(true)));
        $this->assertFalse($this->value->equals(new JsonBoolean(false)));
        $this->assertFalse($this->value->equals(new JsonNull()));
    }

    public function testProcessAsSchema(): void
    {
        $pointer = new JsonPointer();
        $keywords = ['a' => $this->createStub(Keyword::class)];
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $pointer);
        $validator = new BooleanSchemaValidator('https://example.com', true);
        $processedSchema = new ProcessedSchema($validator, $identifier, [], [], $pointer);

        $this->assertEquals([$processedSchema], $this->value->processAsSchema($identifier, $keywords, $pointer));
    }
}
