<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\JsonPointer;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Validator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Validator
 * @uses \Yakimun\JsonSchemaValidator\JsonPointer
 * @uses \Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator
 */
final class ValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $uri;

    /**
     * @var SchemaValidator
     */
    private SchemaValidator $schemaValidator;

    /**
     * @var string
     */
    private string $additionalSchemaUri;

    /**
     * @var SchemaValidator
     */
    private SchemaValidator $additionalSchemaValidator;

    /**
     * @var Validator
     */
    private Validator $validator;

    protected function setUp(): void
    {
        $pointer = new JsonPointer([]);

        $this->uri = 'https://example.com';
        $this->schemaValidator = new ObjectSchemaValidator(new Uri($this->uri), $pointer, []);
        $this->additionalSchemaUri = 'https://example.org';
        $this->additionalSchemaValidator = new ObjectSchemaValidator(new Uri($this->additionalSchemaUri), $pointer, []);
        $this->validator = new Validator(
            $this->schemaValidator,
            [$this->additionalSchemaUri => $this->additionalSchemaValidator],
            [$this->uri],
        );
    }

    public function testGetSchemaValidator(): void
    {
        $expected = $this->schemaValidator;

        $this->assertSame($expected, $this->validator->getSchemaValidator());
    }

    public function testGetSchemaValidators(): void
    {
        $expected = [$this->additionalSchemaUri => $this->additionalSchemaValidator];

        $this->assertSame($expected, $this->validator->getSchemaValidators());
    }

    public function testGetDynamicUris(): void
    {
        $expected = [$this->uri];

        $this->assertSame($expected, $this->validator->getDynamicUris());
    }
}
