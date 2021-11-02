<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinLengthKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinLengthKeywordValidator
 */
final class MinLengthKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $minLength;

    /**
     * @var MinLengthKeywordValidator
     */
    private MinLengthKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->minLength = 0;
        $this->validator = new MinLengthKeywordValidator($this->minLength);
    }

    public function testGetMinLength(): void
    {
        $expected = $this->minLength;

        $this->assertSame($expected, $this->validator->getMinLength());
    }
}
