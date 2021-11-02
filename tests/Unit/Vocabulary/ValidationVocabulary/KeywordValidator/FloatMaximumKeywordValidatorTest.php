<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMaximumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMaximumKeywordValidator
 */
final class FloatMaximumKeywordValidatorTest extends TestCase
{
    /**
     * @var float
     */
    private float $maximum;

    /**
     * @var FloatMaximumKeywordValidator
     */
    private FloatMaximumKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->maximum = 0.0;
        $this->validator = new FloatMaximumKeywordValidator($this->maximum);
    }

    public function testGetMaximum(): void
    {
        $expected = $this->maximum;

        $this->assertSame($expected, $this->validator->getMaximum());
    }
}
