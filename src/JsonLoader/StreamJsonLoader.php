<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\JsonLoader;

use Psr\Http\Message\StreamInterface;
use Yakimun\JsonSchemaValidator\Exception\InvalidValueException;
use Yakimun\JsonSchemaValidator\Json\JsonValue;

final class StreamJsonLoader implements JsonLoader
{
    /**
     * @var StreamInterface
     * @readonly
     */
    private $stream;

    /**
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /**
     * @return JsonValue
     */
    public function load(): JsonValue
    {
        try {
            $loader = new StringJsonLoader($this->stream->getContents());
        } catch (\RuntimeException $e) {
            $message = sprintf('The stream must be readable without errors. Error: "%s".', $e->getMessage());
            throw new InvalidValueException($message);
        }

        return $loader->load();
    }
}
