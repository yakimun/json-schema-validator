<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxItemsKeywordValidator
 */
final class MaxItemsKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $maxItems;

    /**
     * @var MaxItemsKeywordValidator
     */
    private MaxItemsKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->maxItems = 0;
        $this->validator = new MaxItemsKeywordValidator($this->maxItems);
    }

    public function testGetMaxItems(): void
    {
        $expected = $this->maxItems;

        $this->assertSame($expected, $this->validator->getMaxItems());
    }
}
