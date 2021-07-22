<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\UnevaluatedVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordValidator\UnevaluatedItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\KeywordValidator\UnevaluatedItemsKeywordValidator
 */
final class UnevaluatedItemsKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $validator = new UnevaluatedItemsKeywordValidator($this->createStub(SchemaValidator::class));
        $expected = UnevaluatedItemsKeywordValidator::class;

        $this->assertInstanceOf($expected, $validator);
    }
}
