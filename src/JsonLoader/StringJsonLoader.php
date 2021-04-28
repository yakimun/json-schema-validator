<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\JsonLoader;

use Yakimun\JsonSchemaValidator\Exception\InvalidValueException;
use Yakimun\JsonSchemaValidator\Json\JsonValue;

/**
 * @psalm-immutable
 */
final class StringJsonLoader implements JsonLoader
{
    /**
     * @var string
     */
    private $json;

    /**
     * @param string $json
     */
    public function __construct(string $json)
    {
        $this->json = $json;
    }

    /**
     * @return JsonValue
     */
    public function load(): JsonValue
    {
        try {
            $loader = new ValueJsonLoader(json_decode($this->json, false, 512, JSON_THROW_ON_ERROR));
        } catch (\JsonException $e) {
            throw new InvalidValueException('The value must be a JSON document.');
        }

        return $loader->load();
    }
}
