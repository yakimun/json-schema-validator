<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinPropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MinPropertiesKeywordValidator
 */
final class MinPropertiesKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $minProperties;

    /**
     * @var MinPropertiesKeywordValidator
     */
    private MinPropertiesKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->minProperties = 0;
        $this->validator = new MinPropertiesKeywordValidator($this->minProperties);
    }

    public function testGetMinProperties(): void
    {
        $expected = $this->minProperties;

        $this->assertSame($expected, $this->validator->getMinProperties());
    }
}
