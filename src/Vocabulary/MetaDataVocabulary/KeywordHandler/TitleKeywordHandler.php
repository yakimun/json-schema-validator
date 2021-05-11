<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class TitleKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var string
     */
    private $title;

    /**
     * @param string $absoluteLocation
     * @param string $title
     */
    public function __construct(string $absoluteLocation, string $title)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->title = $title;
    }
}
