<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\ValidationVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ArrayTypeKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\KeywordValidator\ArrayTypeKeywordValidator
 */
final class ArrayTypeKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $type;

    /**
     * @var ArrayTypeKeywordValidator
     */
    private ArrayTypeKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->type = 'null';
        $this->validator = new ArrayTypeKeywordValidator([$this->type]);
    }

    public function testGetTypes(): void
    {
        $expected = [$this->type];

        $this->assertSame($expected, $this->validator->getTypes());
    }
}
