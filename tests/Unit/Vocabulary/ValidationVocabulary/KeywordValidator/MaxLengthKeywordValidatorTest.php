<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxLengthKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxLengthKeywordValidator
 */
final class MaxLengthKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $maxLength;

    /**
     * @var MaxLengthKeywordValidator
     */
    private MaxLengthKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->maxLength = 0;
        $this->validator = new MaxLengthKeywordValidator($this->maxLength);
    }

    public function testGetMaxLength(): void
    {
        $expected = $this->maxLength;

        $this->assertSame($expected, $this->validator->getMaxLength());
    }
}
