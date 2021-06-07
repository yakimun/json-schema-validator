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
            /** @var null|scalar|object|array<array-key, mixed> $value */
            $value = json_decode($this->json, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new InvalidValueException(sprintf('Value must be valid JSON document: %s', $e->getMessage()), 0, $e);
        }

        $loader = new ValueJsonLoader($value);

        return $loader->load();
    }
}
