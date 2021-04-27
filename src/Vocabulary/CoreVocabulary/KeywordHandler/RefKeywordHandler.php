<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\KeywordHandler;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

/**
 * @psalm-immutable
 */
final class RefKeywordHandler implements KeywordHandler
{
    /**
     * @var UriInterface
     */
    private $ref;

    /**
     * @param UriInterface $ref
     */
    public function __construct(UriInterface $ref)
    {
        $this->ref = $ref;
    }
}
