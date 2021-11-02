<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinItemsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinItemsKeywordValidator
 */
final class MinItemsKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $minItems;

    /**
     * @var MinItemsKeywordValidator
     */
    private MinItemsKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->minItems = 0;
        $this->validator = new MinItemsKeywordValidator($this->minItems);
    }

    public function testGetMinItems(): void
    {
        $expected = $this->minItems;

        $this->assertSame($expected, $this->validator->getMinItems());
    }
}
