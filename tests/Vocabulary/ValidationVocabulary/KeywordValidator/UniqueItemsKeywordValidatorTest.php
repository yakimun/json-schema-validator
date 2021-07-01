<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\UniqueItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\UniqueItemsKeywordValidator
 */
final class UniqueItemsKeywordValidatorTest extends TestCase
{
    public function testConstruct(): void
    {
        $expected = UniqueItemsKeywordValidator::class;

        $this->assertInstanceOf($expected, new UniqueItemsKeywordValidator(true));
    }
}
