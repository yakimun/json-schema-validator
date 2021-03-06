<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\RequiredKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\RequiredKeywordValidator
 */
final class RequiredKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = RequiredKeywordValidator::class;

        $this->assertInstanceOf($expected, new RequiredKeywordValidator([]));
    }
}
