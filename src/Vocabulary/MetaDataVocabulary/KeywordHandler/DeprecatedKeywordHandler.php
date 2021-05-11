<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class DeprecatedKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var bool
     */
    private $deprecated;

    /**
     * @param string $absoluteLocation
     * @param bool $deprecated
     */
    public function __construct(string $absoluteLocation, bool $deprecated)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->deprecated = $deprecated;
    }
}
