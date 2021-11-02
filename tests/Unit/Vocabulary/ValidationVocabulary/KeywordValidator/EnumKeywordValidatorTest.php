<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\EnumKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\EnumKeywordValidator
 */
final class EnumKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $element;

    /**
     * @var EnumKeywordValidator
     */
    private EnumKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->element = 'a';
        $this->validator = new EnumKeywordValidator([$this->element]);
    }

    public function testGetElements(): void
    {
        $expected = [$this->element];

        $this->assertSame($expected, $this->validator->getElements());
    }
}
