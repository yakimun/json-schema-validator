<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\SchemaValidator;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 */
final class ObjectSchemaValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $validator = new ObjectSchemaValidator(new Uri('https://example.com'), new JsonPointer(), []);
        $expected = ObjectSchemaValidator::class;

        $this->assertInstanceOf($expected, $validator);
    }
}
