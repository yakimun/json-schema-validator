<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class DescriptionKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var string
     */
    private $description;

    /**
     * @param string $absoluteLocation
     * @param string $description
     */
    public function __construct(string $absoluteLocation, string $description)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->description = $description;
    }
}
