<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMaximumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\FloatExclusiveMaximumKeywordValidator
 */
final class FloatExclusiveMaximumKeywordValidatorTest extends TestCase
{
    /**
     * @var float
     */
    private float $exclusiveMaximum;

    /**
     * @var FloatExclusiveMaximumKeywordValidator
     */
    private FloatExclusiveMaximumKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->exclusiveMaximum = 0.0;
        $this->validator = new FloatExclusiveMaximumKeywordValidator($this->exclusiveMaximum);
    }

    public function testGetExclusiveMaximum(): void
    {
        $expected = $this->exclusiveMaximum;

        $this->assertSame($expected, $this->validator->getExclusiveMaximum());
    }
}
