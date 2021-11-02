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
     * @var string
     */
    private string $dynamicUri;

    /**
     * @var Validator
     */
    private Validator $validator;

    protected function setUp(): void
    {
        $this->schemaValidator = $this->createStub(SchemaValidator::class);
        $this->additionalSchemaUri = 'https://example.org';
        $this->additionalSchemaValidator = $this->createStub(SchemaValidator::class);
        $this->dynamicUri = 'https://example.com';
        $this->validator = new Validator(
            $this->schemaValidator,
            [$this->additionalSchemaUri => $this->additionalSchemaValidator],
            [$this->dynamicUri],
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
        $expected = [$this->dynamicUri];

        $this->assertSame($expected, $this->validator->getDynamicUris());
    }
}
