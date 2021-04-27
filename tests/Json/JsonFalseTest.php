<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Json;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonFalse;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\ProcessedSchema;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\FalseSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Json\JsonFalse
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\FalseSchemaValidator
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

    public function testProcessAsSchema(): void
    {
        $keywords = ['foo' => $this->createStub(Keyword::class)];
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), new JsonPointer());
        $validator = new FalseSchemaValidator($identifier);
        $processedSchema = new ProcessedSchema($validator, $identifier, [], [], new JsonPointer('a'));

        $this->assertEquals([$processedSchema], $this->value->processAsSchema($identifier, $keywords));
    }
}
