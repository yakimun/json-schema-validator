<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class ReadOnlyKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var bool
     */
    private $readOnly;

    /**
     * @param string $absoluteLocation
     * @param bool $readOnly
     */
    public function __construct(string $absoluteLocation, bool $readOnly)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->readOnly = $readOnly;
    }
}
