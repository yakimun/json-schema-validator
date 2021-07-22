<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ApplicatorVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordValidator\ItemsKeywordValidator
 */
final class ItemsKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = ItemsKeywordValidator::class;

        $this->assertInstanceOf($expected, new ItemsKeywordValidator($this->createStub(SchemaValidator::class)));
    }
}
