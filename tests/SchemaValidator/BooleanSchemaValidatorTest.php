<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\SchemaValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator
 */
final class BooleanSchemaValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(BooleanSchemaValidator::class, new BooleanSchemaValidator('https://example.com', true));
    }
}
