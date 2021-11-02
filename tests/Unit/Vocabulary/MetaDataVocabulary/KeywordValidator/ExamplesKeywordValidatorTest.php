<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ExamplesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ExamplesKeywordValidator
 */
final class ExamplesKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $example;

    /**
     * @var ExamplesKeywordValidator
     */
    private ExamplesKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->example = 'a';
        $this->validator = new ExamplesKeywordValidator([$this->example]);
    }

    public function testGetExamples(): void
    {
        $expected = [$this->example];

        $this->assertSame($expected, $this->validator->getExamples());
    }
}
