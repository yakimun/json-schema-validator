<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMinimumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMinimumKeywordValidator
 */
final class IntMinimumKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $minimum;

    /**
     * @var IntMinimumKeywordValidator
     */
    private IntMinimumKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->minimum = 0;
        $this->validator = new IntMinimumKeywordValidator($this->minimum);
    }

    public function testGetMinimum(): void
    {
        $expected = $this->minimum;

        $this->assertSame($expected, $this->validator->getMinimum());
    }
}
