<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\JsonLoader;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Json\JsonNull;
use Yakimun\JsonSchemaValidator\JsonLoader\MemoryJsonLoader;

/**
 * @covers \Yakimun\JsonSchemaValidator\JsonLoader\MemoryJsonLoader
 */
final class MemoryJsonLoaderTest extends TestCase
{
    public function testLoad(): void
    {
        $value = new JsonNull();
        $loader = new MemoryJsonLoader($value);

        $this->assertSame($value, $loader->load());
    }
}
