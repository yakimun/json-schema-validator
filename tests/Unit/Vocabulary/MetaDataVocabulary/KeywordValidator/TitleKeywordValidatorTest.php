<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\MetaDataVocabulary\KeywordValidator;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\TitleKeywordValidator;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordValidator\TitleKeywordValidator
 */
final class TitleKeywordValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private string $title;

    /**
     * @var TitleKeywordValidator
     */
    private TitleKeywordValidator $validator;

    protected function setUp(): void
    {
        $this->title = 'a';
        $this->validator = new TitleKeywordValidator($this->title);
    }

    public function testGetTitle(): void
    {
        $expected = $this->title;

        $this->assertSame($expected, $this->validator->getTitle());
    }
}
