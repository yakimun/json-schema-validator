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
    public function testConstruct(): void
    {
        $expected = DynamicAnchorKeywordValidator::class;

        $this->assertInstanceOf($expected, new DynamicAnchorKeywordValidator('a'));
    }
}
