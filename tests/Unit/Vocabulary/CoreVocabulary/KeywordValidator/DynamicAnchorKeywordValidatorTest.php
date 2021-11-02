<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\CoreVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicAnchorKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator\DynamicAnchorKeywordValidator
 */
final class DynamicAnchorKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $dynamicAnchor;

    /**
     * @var DynamicAnchorKeywordValidator
     */
    private DynamicAnchorKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->dynamicAnchor = 'a';
        $this->validator = new DynamicAnchorKeywordValidator($this->dynamicAnchor);
    }

    public function testGetDynamicAnchor(): void
    {
        $expected = $this->dynamicAnchor;

        $this->assertSame($expected, $this->validator->getDynamicAnchor());
    }
}
