<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMinimumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMinimumKeywordValidator
 */
final class FloatExclusiveMinimumKeywordValidatorTest extends TestCase
{
    /**
     * @var float
     */
    private float $exclusiveMinimum;

    /**
     * @var FloatExclusiveMinimumKeywordValidator
     */
    private FloatExclusiveMinimumKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->exclusiveMinimum = 0.0;
        $this->validator = new FloatExclusiveMinimumKeywordValidator($this->exclusiveMinimum);
    }

    public function testGetExclusiveMinimum(): void
    {
        $expected = $this->exclusiveMinimum;

        $this->assertSame($expected, $this->validator->getExclusiveMinimum());
    }
}
