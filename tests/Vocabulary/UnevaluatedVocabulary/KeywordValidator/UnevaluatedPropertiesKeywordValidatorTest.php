<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\UnevaluatedVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordValidator\UnevaluatedPropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordValidator\UnevaluatedPropertiesKeywordValidator
 */
final class UnevaluatedPropertiesKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $validator = new UnevaluatedPropertiesKeywordValidator($this->createStub(SchemaValidator::class));
        $expected = UnevaluatedPropertiesKeywordValidator::class;

        $this->assertInstanceOf($expected, $validator);
    }
}
