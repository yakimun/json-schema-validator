<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ConstKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ConstKeywordValidator
 */
final class ConstKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = ConstKeywordValidator::class;

        $this->assertInstanceOf($expected, new ConstKeywordValidator(null));
    }
}
