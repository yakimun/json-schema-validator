<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\JsonPointer;

/**
 * @covers \Yakimun\JsonSchemaValidator\Exception\SchemaException
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class SchemaExceptionTest extends TestCase
{
    public function testGetPath(): void
    {
        $expected = new JsonPointer();
        $exception = new SchemaException('a', $expected);

        $this->assertSame($expected, $exception->getPath());
    }
}
