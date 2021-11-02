<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class DynamicAnchorKeywordValidator implements KeywordValidator
{
    /**
     * @var string
     */
    private string $dynamicAnchor;

    /**
     * @param string $dynamicAnchor
     */
    public function __construct(string $dynamicAnchor)
    {
        $this->dynamicAnchor = $dynamicAnchor;
    }

    /**
     * @return string
     */
    public function getDynamicAnchor(): string
    {
        return $this->dynamicAnchor;
    }
}
