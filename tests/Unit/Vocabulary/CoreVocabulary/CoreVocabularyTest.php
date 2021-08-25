<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Unit\Vocabulary\CoreVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\CoreVocabulary;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\AnchorKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\CommentKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DefsKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicAnchorKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\DynamicRefKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\IdKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\RefKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\SchemaKeyword;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\Keyword\VocabularyKeyword;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\CoreVocabulary
 */
final class CoreVocabularyTest extends TestCase
{
    public function testGetKeywords(): void
    {
        $vocabulary = new CoreVocabulary();
        $expected = [
            SchemaKeyword::NAME => new SchemaKeyword(),
            VocabularyKeyword::NAME => new VocabularyKeyword(),
            IdKeyword::NAME => new IdKeyword(),
            AnchorKeyword::NAME => new AnchorKeyword(),
            DynamicAnchorKeyword::NAME => new DynamicAnchorKeyword(),
            RefKeyword::NAME => new RefKeyword(),
            DynamicRefKeyword::NAME => new DynamicRefKeyword(),
            DefsKeyword::NAME => new DefsKeyword(),
            CommentKeyword::NAME => new CommentKeyword(),
        ];

        $this->assertEquals($expected, $vocabulary->getKeywords());
    }
}
