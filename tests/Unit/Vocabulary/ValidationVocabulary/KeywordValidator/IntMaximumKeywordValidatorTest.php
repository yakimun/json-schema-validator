<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMaximumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMaximumKeywordValidator
 */
final class IntMaximumKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $maximum;

    /**
     * @var IntMaximumKeywordValidator
     */
    private IntMaximumKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->maximum = 0;
        $this->validator = new IntMaximumKeywordValidator($this->maximum);
    }

    public function testGetMaximum(): void
    {
        $expected = $this->maximum;

        $this->assertSame($expected, $this->validator->getMaximum());
    }
}
