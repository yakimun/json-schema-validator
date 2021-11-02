<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DefaultKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DefaultKeywordValidator
 */
final class DefaultKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $default;

    /**
     * @var DefaultKeywordValidator
     */
    private DefaultKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->default = 'a';
        $this->validator = new DefaultKeywordValidator($this->default);
    }

    public function testGetDefault(): void
    {
        $expected = $this->default;

        $this->assertSame($expected, $this->validator->getDefault());
    }
}
