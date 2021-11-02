<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\WriteOnlyKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\WriteOnlyKeywordValidator
 */
final class WriteOnlyKeywordValidatorTest extends TestCase
{
    /**
     * @var bool
     */
    private bool $writeOnly;

    /**
     * @var WriteOnlyKeywordValidator
     */
    private WriteOnlyKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->writeOnly = true;
        $this->validator = new WriteOnlyKeywordValidator($this->writeOnly);
    }

    public function testIsWriteOnly(): void
    {
        $expected = $this->writeOnly;

        $this->assertSame($expected, $this->validator->isWriteOnly());
    }
}
