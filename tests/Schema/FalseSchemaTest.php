<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Schema;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonFalse;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Schema\FalseSchema;
use Yakimun\JsonSchemaValidator\Schema\ProcessedSchema;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\FalseSchemaValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Schema\FalseSchema
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonFalse
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Schema\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\FalseSchemaValidator
 */
final class FalseSchemaTest extends TestCase
{
    public function testProcess(): void
    {
        $path = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $path);
        $schema = new FalseSchema(new JsonFalse($path), $identifier);
        $processedSchema = new ProcessedSchema(new FalseSchemaValidator($identifier), $identifier, [], [], $path);

        $this->assertEquals([$processedSchema], $schema->process());
    }
}
