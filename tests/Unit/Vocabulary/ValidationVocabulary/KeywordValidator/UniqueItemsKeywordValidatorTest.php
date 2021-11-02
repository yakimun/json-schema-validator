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
    /**
     * @var bool
     */
    private bool $uniqueItems;

    /**
     * @var UniqueItemsKeywordValidator
     */
    private UniqueItemsKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->uniqueItems = true;
        $this->validator = new UniqueItemsKeywordValidator($this->uniqueItems);
    }

    public function testIsUniqueItems(): void
    {
        $expected = $this->uniqueItems;

        $this->assertSame($expected, $this->validator->isUniqueItems());
    }
}
