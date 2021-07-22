<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AllOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AllOfKeywordValidator
 */
final class AllOfKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = AllOfKeywordValidator::class;

        $this->assertInstanceOf($expected, new AllOfKeywordValidator([]));
    }
}
