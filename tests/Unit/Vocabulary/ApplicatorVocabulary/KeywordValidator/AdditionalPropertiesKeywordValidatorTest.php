<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AdditionalPropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\AdditionalPropertiesKeywordValidator
 */
final class AdditionalPropertiesKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $validator = new AdditionalPropertiesKeywordValidator($this->createStub(SchemaValidator::class));
        $expected = AdditionalPropertiesKeywordValidator::class;

        $this->assertInstanceOf($expected, $validator);
    }
}
