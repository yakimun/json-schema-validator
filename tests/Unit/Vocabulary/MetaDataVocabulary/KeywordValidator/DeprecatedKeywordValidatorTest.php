<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DeprecatedKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DeprecatedKeywordValidator
 */
final class DeprecatedKeywordValidatorTest extends TestCase
{
    /**
     * @var bool
     */
    private bool $deprecated;

    /**
     * @var DeprecatedKeywordValidator
     */
    private DeprecatedKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->deprecated = true;
        $this->validator = new DeprecatedKeywordValidator($this->deprecated);
    }

    public function testIsDeprecated(): void
    {
        $expected = $this->deprecated;

        $this->assertSame($expected, $this->validator->isDeprecated());
    }
}
