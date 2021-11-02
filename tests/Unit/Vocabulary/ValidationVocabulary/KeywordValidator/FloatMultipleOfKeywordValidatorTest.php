<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMultipleOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatMultipleOfKeywordValidator
 */
final class FloatMultipleOfKeywordValidatorTest extends TestCase
{
    /**
     * @var float
     */
    private float $multipleOf;

    /**
     * @var FloatMultipleOfKeywordValidator
     */
    private FloatMultipleOfKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->multipleOf = 0.0;
        $this->validator = new FloatMultipleOfKeywordValidator($this->multipleOf);
    }

    public function testGetMultipleOf(): void
    {
        $expected = $this->multipleOf;

        $this->assertSame($expected, $this->validator->getMultipleOf());
    }
}
