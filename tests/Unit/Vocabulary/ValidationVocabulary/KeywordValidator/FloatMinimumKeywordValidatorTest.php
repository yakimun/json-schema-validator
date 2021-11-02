<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMinimumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMinimumKeywordValidator
 */
final class FloatMinimumKeywordValidatorTest extends TestCase
{
    /**
     * @var float
     */
    private float $minimum;

    /**
     * @var FloatMinimumKeywordValidator
     */
    private FloatMinimumKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->minimum = 0.0;
        $this->validator = new FloatMinimumKeywordValidator($this->minimum);
    }

    public function testGetMinimum(): void
    {
        $expected = $this->minimum;

        $this->assertSame($expected, $this->validator->getMinimum());
    }
}
