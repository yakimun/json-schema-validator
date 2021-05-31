<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\SchemaLoader;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\JsonLoader\JsonLoader;
use Yakimun\JsonSchemaValidator\SchemaLoader\SimpleSchemaLoader;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaLoader\SimpleSchemaLoader
 */
final class SimpleSchemaLoaderTest extends TestCase
{
    public function testLoad(): void
    {
        $uri = new Uri('https://example.com/schema');
        $value = $this->createStub(JsonValue::class);

        $jsonLoader = $this->createMock(JsonLoader::class);
        $jsonLoader
            ->expects($this->once())
            ->method('load')
            ->willReturn($value);

        $loader = new SimpleSchemaLoader($uri, $jsonLoader);

        $this->assertEquals($value, $loader->load($uri));
    }

    public function testLoadWithInvalidUri(): void
    {
        $jsonLoader = $this->createMock(JsonLoader::class);
        $jsonLoader
            ->expects($this->never())
            ->method('load');

        $loader = new SimpleSchemaLoader(new Uri('https://example.com/schema1'), $jsonLoader);

        $this->assertNull($loader->load(new Uri('https://example.com/schema2')));
    }
}
