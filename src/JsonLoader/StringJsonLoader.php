<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\JsonLoader;

use Yakimun\JsonSchemaValidator\Exception\JsonLoaderException;
use Yakimun\JsonSchemaValidator\Json\JsonValue;

final class StringJsonLoader implements JsonLoader
{
    /**
     * @var string
     * @readonly
     */
    private string $json;

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
            /**
             * @var list<mixed>|null|object|scalar $value
             */
            $value = json_decode($this->json, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $message = sprintf('The value must be a valid JSON document. Error: "%s".', $e->getMessage());
            throw new JsonLoaderException($message, 0, $e);
        }

        $loader = new MixedJsonLoader($value);

        return $loader->load();
    }
}
