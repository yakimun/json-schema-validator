<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DescriptionKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\DescriptionKeywordValidator
 */
final class DescriptionKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $description;

    /**
     * @var DescriptionKeywordValidator
     */
    private DescriptionKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->description = 'a';
        $this->validator = new DescriptionKeywordValidator($this->description);
    }

    public function testGetDescription(): void
    {
        $expected = $this->description;

        $this->assertSame($expected, $this->validator->getDescription());
    }
}
