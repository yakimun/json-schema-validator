<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Validator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Validator
 */
final class ValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $validator = new Validator(['https://example.com' => $this->createStub(SchemaValidator::class)]);
        $expected = Validator::class;

        $this->assertInstanceOf($expected, $validator);
    }
}
