<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxPropertiesKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\MaxPropertiesKeywordValidator
 */
final class MaxPropertiesKeywordValidatorTest extends TestCase
{
    /**
     * @var int
     */
    private int $maxProperties;

    /**
     * @var MaxPropertiesKeywordValidator
     */
    private MaxPropertiesKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->maxProperties = 0;
        $this->validator = new MaxPropertiesKeywordValidator($this->maxProperties);
    }

    public function testGetMaxProperties(): void
    {
        $expected = $this->maxProperties;

        $this->assertSame($expected, $this->validator->getMaxProperties());
    }
}
