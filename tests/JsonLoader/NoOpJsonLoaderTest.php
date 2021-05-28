<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\JsonLoader;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonLoader\NoOpJsonLoader;

/**
 * @covers \Yakimun\JsonSchemaValidator\JsonLoader\NoOpJsonLoader
 * @uses \Yakimun\JsonSchemaValidator\Json\JsonNull
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class NoOpJsonLoaderTest extends TestCase
{
    public function testLoad(): void
    {
        $value = new JsonNull();
        $loader = new NoOpJsonLoader($value);

        $this->assertEquals($value, $loader->load());
    }
}
