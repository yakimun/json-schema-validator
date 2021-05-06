<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\SchemaValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class ObjectSchemaValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(ObjectSchemaValidator::class, new ObjectSchemaValidator('https://example.com', []));
    }
}
