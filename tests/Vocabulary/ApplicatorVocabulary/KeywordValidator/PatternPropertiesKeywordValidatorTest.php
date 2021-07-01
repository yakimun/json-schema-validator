<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PatternPropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PatternPropertiesKeywordValidator
 */
final class PatternPropertiesKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = PatternPropertiesKeywordValidator::class;

        $this->assertInstanceOf($expected, new PatternPropertiesKeywordValidator([]));
    }
}
