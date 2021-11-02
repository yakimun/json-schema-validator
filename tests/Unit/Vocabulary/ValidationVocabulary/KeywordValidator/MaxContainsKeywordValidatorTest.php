<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxContainsKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxContainsKeywordValidator
 */
final class MaxContainsKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $maxContains;

    /**
     * @var MaxContainsKeywordValidator
     */
    private MaxContainsKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->maxContains = 0;
        $this->validator = new MaxContainsKeywordValidator($this->maxContains);
    }

    public function testGetMaxContains(): void
    {
        $expected = $this->maxContains;

        $this->assertSame($expected, $this->validator->getMaxContains());
    }
}
