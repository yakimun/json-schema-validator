<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Tests\Vocabulary\CoreVocabulary;

use PHPUnit\Framework\TestCase;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\DynamicAnchorKeywordHandler;

/**
 * @covers \Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\DynamicAnchorKeywordHandler
 */
final class DynamicAnchorKeywordHandlerTest extends TestCase
{
    public function testConstruct(): void
    {
        $keywordHandler = new DynamicAnchorKeywordHandler('a');

        $this->assertInstanceOf(DynamicAnchorKeywordHandler::class, $keywordHandler);
    }
}
