<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\SchemaValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\TrueSchemaValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaValidator\TrueSchemaValidator
 */
final class TrueSchemaValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(TrueSchemaValidator::class, new TrueSchemaValidator('https://example.com'));
    }
}
