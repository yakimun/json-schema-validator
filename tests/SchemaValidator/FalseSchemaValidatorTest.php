<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\SchemaValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\FalseSchemaValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaValidator\FalseSchemaValidator
 */
final class FalseSchemaValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(FalseSchemaValidator::class, new FalseSchemaValidator('https://example.com'));
    }
}
