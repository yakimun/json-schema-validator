<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMinimumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntExclusiveMinimumKeywordValidator
 */
final class IntExclusiveMinimumKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $exclusiveMinimum;

    /**
     * @var IntExclusiveMinimumKeywordValidator
     */
    private IntExclusiveMinimumKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->exclusiveMinimum = 0;
        $this->validator = new IntExclusiveMinimumKeywordValidator($this->exclusiveMinimum);
    }

    public function testGetExclusiveMinimum(): void
    {
        $expected = $this->exclusiveMinimum;

        $this->assertSame($expected, $this->validator->getExclusiveMinimum());
    }
}
