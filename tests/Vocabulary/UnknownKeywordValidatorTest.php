<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordValidator
 */
final class UnknownKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = UnknownKeywordValidator::class;

        $this->assertInstanceOf($expected, new UnknownKeywordValidator('a', null));
    }
}
