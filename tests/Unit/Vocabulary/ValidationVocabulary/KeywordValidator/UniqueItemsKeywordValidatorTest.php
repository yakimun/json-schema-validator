<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\UniqueItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\UniqueItemsKeywordValidator
 */
final class UniqueItemsKeywordValidatorTest extends TestCase
{
    public function testGetUniqueItems(): void
    {
        $expected = true;
        $validator = new UniqueItemsKeywordValidator($expected);

        $this->assertSame($expected, $validator->getUniqueItems());
    }
}
