<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMaximumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMaximumKeywordValidator
 */
final class FloatMaximumKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = FloatMaximumKeywordValidator::class;

        $this->assertInstanceOf($expected, new FloatMaximumKeywordValidator(0));
    }
}
