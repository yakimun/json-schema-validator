<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler;

use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class RefKeywordHandler implements KeywordHandler
{
    /**
     * @var string
     */
    private $absoluteLocation;

    /**
     * @var string
     */
    private $ref;

    /**
     * @param string $absoluteLocation
     * @param string $ref
     */
    public function __construct(string $absoluteLocation, string $ref)
    {
        $this->absoluteLocation = $absoluteLocation;
        $this->ref = $ref;
    }
}
