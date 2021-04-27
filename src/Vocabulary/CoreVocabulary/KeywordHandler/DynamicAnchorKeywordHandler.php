<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class DynamicAnchorKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $dynamicAnchor;

    /**
     * @param string $dynamicAnchor
     */
    public function __construct(string $dynamicAnchor)
    {
        $this->dynamicAnchor = $dynamicAnchor;
    }
}
