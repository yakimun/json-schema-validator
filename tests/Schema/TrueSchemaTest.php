<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Schema;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonPointer;
use Yakimun\JsonSchemaValidator\Json\JsonTrue;
use Yakimun\JsonSchemaValidator\Schema\ProcessedSchema;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\Schema\TrueSchema;
use Yakimun\JsonSchemaValidator\SchemaValidator\TrueSchemaValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Schema\TrueSchema
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonTrue
 * @uses \Yakimun\JsonSchemaValidator\Schema\ProcessedSchema
 * @uses \Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\TrueSchemaValidator
 */
final class TrueSchemaTest extends TestCase
{
    public function testProcess(): void
    {
        $path = new JsonPointer();
        $identifier = new SchemaIdentifier(new Uri('https://example.com'), $path);
        $schema = new TrueSchema(new JsonTrue($path), $identifier);
        $processedSchema = new ProcessedSchema(new TrueSchemaValidator($identifier), $identifier, [], [], $path);

        $this->assertEquals([$processedSchema], $schema->process());
    }
}
