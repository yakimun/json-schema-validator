<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\StringTypeKeywordValidator
 */
final class StringTypeKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $type;

    /**
     * @var StringTypeKeywordValidator
     */
    private StringTypeKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->type = 'null';
        $this->validator = new StringTypeKeywordValidator($this->type);
    }

    public function testGetType(): void
    {
        $expected = $this->type;

        $this->assertSame($expected, $this->validator->getType());
    }
}
