<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class WriteOnlyKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var bool
     */
    private $writeOnly;

    /**
     * @param string $absoluteLocation
     * @param bool $writeOnly
     */
    public function __construct(string $absoluteLocation, bool $writeOnly)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->writeOnly = $writeOnly;
    }
}
