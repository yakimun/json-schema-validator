<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class ContentEncodingKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var string
     */
    private $contentEncoding;

    /**
     * @param string $absoluteLocation
     * @param string $contentEncoding
     */
    public function __construct(string $absoluteLocation, string $contentEncoding)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->contentEncoding = $contentEncoding;
    }
}
