<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\PropertiesKeywordValidator
 */
final class PropertiesKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = PropertiesKeywordValidator::class;

        $this->assertInstanceOf($expected, new PropertiesKeywordValidator([]));
    }
}
