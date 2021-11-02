<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ConstKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ConstKeywordValidator
 */
final class ConstKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $const;

    /**
     * @var ConstKeywordValidator
     */
    private ConstKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->const = 'a';
        $this->validator = new ConstKeywordValidator($this->const);
    }

    public function testGetConst(): void
    {
        $expected = $this->const;

        $this->assertSame($expected, $this->validator->getConst());
    }
}
