<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinPropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinPropertiesKeywordValidator
 */
final class MinPropertiesKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = MinPropertiesKeywordValidator::class;

        $this->assertInstanceOf($expected, new MinPropertiesKeywordValidator(0));
    }
}
