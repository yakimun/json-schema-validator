<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordValidator;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordValidator;

/**
 * @psalm-immutable
 */
final class ContentMediaTypeKeywordValidator implements KeywordValidator
{
    /**
     * @var string
     */
    private string $contentMediaType;

    /**
     * @param string $contentMediaType
     */
    public function __construct(string $contentMediaType)
    {
        $this->contentMediaType = $contentMediaType;
    }

    /**
     * @return string
     */
    public function getContentMediaType(): string
    {
        return $this->contentMediaType;
    }
}
