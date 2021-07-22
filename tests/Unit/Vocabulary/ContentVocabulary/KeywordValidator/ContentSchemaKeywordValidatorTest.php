<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ContentVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentSchemaKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator\ContentSchemaKeywordValidator
 */
final class ContentSchemaKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $validator = new ContentSchemaKeywordValidator($this->createStub(SchemaValidator::class));
        $expected = ContentSchemaKeywordValidator::class;

        $this->assertInstanceOf($expected, $validator);
    }
}
