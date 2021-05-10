<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class ContentMediaTypeKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var string
     */
    private $contentMediaType;

    /**
     * @param string $absoluteLocation
     * @param string $contentMediaType
     */
    public function __construct(string $absoluteLocation, string $contentMediaType)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->contentMediaType = $contentMediaType;
    }
}
