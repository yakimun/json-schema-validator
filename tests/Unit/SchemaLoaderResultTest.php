<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaLoaderResult;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaLoaderResult
 */
final class SchemaLoaderResultTest extends TestCase
{
    public function testGetSchema(): void
    {
        $expected = (object)[];
        $result = new SchemaLoaderResult($expected);

        $this->assertSame($expected, $result->getSchema());
    }
}
