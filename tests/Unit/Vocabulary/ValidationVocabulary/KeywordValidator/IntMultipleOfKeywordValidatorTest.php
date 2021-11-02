<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMultipleOfKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\IntMultipleOfKeywordValidator
 */
final class IntMultipleOfKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $multipleOf;

    /**
     * @var IntMultipleOfKeywordValidator
     */
    private IntMultipleOfKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->multipleOf = 0;
        $this->validator = new IntMultipleOfKeywordValidator($this->multipleOf);
    }

    public function testGetMultipleOf(): void
    {
        $expected = $this->multipleOf;

        $this->assertSame($expected, $this->validator->getMultipleOf());
    }
}
