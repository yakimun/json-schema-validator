<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordValidator
 */
final class UnknownKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $value;

    /**
     * @var UnknownKeywordValidator
     */
    private UnknownKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->name = 'a';
        $this->value = 'b';
        $this->validator = new UnknownKeywordValidator($this->name, $this->value);
    }

    public function testGetName(): void
    {
        $expected = $this->name;

        $this->assertSame($expected, $this->validator->getName());
    }

    public function testGetValue(): void
    {
        $expected = $this->value;

        $this->assertSame($expected, $this->validator->getValue());
    }
}
