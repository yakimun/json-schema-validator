<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\PatternKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\PatternKeywordValidator
 */
final class PatternKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $pattern;

    /**
     * @var PatternKeywordValidator
     */
    private PatternKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->pattern = '/a/';
        $this->validator = new PatternKeywordValidator($this->pattern);
    }

    public function testGetPattern(): void
    {
        $expected = $this->pattern;

        $this->assertSame($expected, $this->validator->getPattern());
    }
}
