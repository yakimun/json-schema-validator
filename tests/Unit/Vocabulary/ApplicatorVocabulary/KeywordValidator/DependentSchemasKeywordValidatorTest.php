<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\DependentSchemasKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\DependentSchemasKeywordValidator
 */
final class DependentSchemasKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = DependentSchemasKeywordValidator::class;

        $this->assertInstanceOf($expected, new DependentSchemasKeywordValidator([]));
    }
}
