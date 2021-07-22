<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxPropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxPropertiesKeywordValidator
 */
final class MaxPropertiesKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = MaxPropertiesKeywordValidator::class;

        $this->assertInstanceOf($expected, new MaxPropertiesKeywordValidator(0));
    }
}
