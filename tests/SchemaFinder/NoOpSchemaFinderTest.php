<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\SchemaFinder;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonLoader\JsonLoader;
use Yakimun\JsonSchemaValidator\SchemaFinder\NoOpSchemaFinder;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaFinder\NoOpSchemaFinder
 */
final class NoOpSchemaFinderTest extends TestCase
{
    public function testLoad(): void
    {
        $uri = new Uri('https://example.com/schema');
        $loader = $this->createStub(JsonLoader::class);
        $finder = new NoOpSchemaFinder($uri, $loader);

        $this->assertEquals($loader, $finder->find($uri));
    }

    public function testLoadWithInvalidUri(): void
    {
        $loader = $this->createStub(JsonLoader::class);
        $finder = new NoOpSchemaFinder(new Uri('https://example.com/schema1'), $loader);

        $this->assertNull($finder->find(new Uri('https://example.com/schema2')));
    }
}
