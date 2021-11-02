<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ReadOnlyKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\ReadOnlyKeywordValidator
 */
final class ReadOnlyKeywordValidatorTest extends TestCase
{
    /**
     * @var bool
     */
    private bool $readOnly;

    /**
     * @var ReadOnlyKeywordValidator
     */
    private ReadOnlyKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->readOnly = true;
        $this->validator = new ReadOnlyKeywordValidator($this->readOnly);
    }

    public function testIsReadOnly(): void
    {
        $expected = $this->readOnly;

        $this->assertSame($expected, $this->validator->isReadOnly());
    }
}
