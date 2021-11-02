<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinContainsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinContainsKeywordValidator
 */
final class MinContainsKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $minContains;

    /**
     * @var MinContainsKeywordValidator
     */
    private MinContainsKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->minContains = 0;
        $this->validator = new MinContainsKeywordValidator($this->minContains);
    }

    public function testGetMinContains(): void
    {
        $expected = $this->minContains;

        $this->assertSame($expected, $this->validator->getMinContains());
    }
}
