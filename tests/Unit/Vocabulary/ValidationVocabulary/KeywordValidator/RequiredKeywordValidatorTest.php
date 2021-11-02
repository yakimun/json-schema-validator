<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\RequiredKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\RequiredKeywordValidator
 */
final class RequiredKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $requiredProperty;

    /**
     * @var RequiredKeywordValidator
     */
    private RequiredKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->requiredProperty = 'a';
        $this->validator = new RequiredKeywordValidator([$this->requiredProperty]);
    }

    public function testGetRequiredProperties(): void
    {
        $expected = [$this->requiredProperty];

        $this->assertSame($expected, $this->validator->getRequiredProperties());
    }
}
