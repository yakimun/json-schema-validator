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
            $json = $this->stream->getContents();
        } catch (\RuntimeException $e) {
            $message = sprintf('Stream must be readable without errors: %s', $e->getMessage());
            throw new InvalidValueException($message, 0, $e);
        }

        $loader = new StringJsonLoader($json);

        return $loader->load();
    }
}
