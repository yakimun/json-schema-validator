<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMaximumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMaximumKeywordValidator
 */
final class IntExclusiveMaximumKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $exclusiveMaximum;

    /**
     * @var IntExclusiveMaximumKeywordValidator
     */
    private IntExclusiveMaximumKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->exclusiveMaximum = 0;
        $this->validator = new IntExclusiveMaximumKeywordValidator($this->exclusiveMaximum);
    }

    public function testGetExclusiveMaximum(): void
    {
        $expected = $this->exclusiveMaximum;

        $this->assertSame($expected, $this->validator->getExclusiveMaximum());
    }
}
