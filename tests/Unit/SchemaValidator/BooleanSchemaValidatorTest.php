<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\SchemaValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class BooleanSchemaValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $validator = new BooleanSchemaValidator(new Uri('https://example.com'), new JsonPointer(), true);
        $expected = BooleanSchemaValidator::class;

        $this->assertInstanceOf($expected, $validator);
    }
}
