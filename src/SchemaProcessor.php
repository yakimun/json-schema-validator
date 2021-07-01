<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\SchemaValidator\BooleanSchemaValidator;
use Yakimun\JsonSchemaValidator\SchemaValidator\ObjectSchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\UnknownKeywordValidator;

final class SchemaProcessor
{
    /**
     * @var non-empty-array<string, Keyword>
     */
    private array $keywords;

    /**
     * @param non-empty-array<string, Keyword> $keywords
     */
    public function __construct(array $keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @param mixed $schema
     * @param UriInterface $uri
     * @param JsonPointer $fragment
     * @param JsonPointer $path
     * @return non-empty-list<ProcessedSchema>
     */
    public function process($schema, UriInterface $uri, JsonPointer $fragment, JsonPointer $path): array
    {
        $identifier = new SchemaIdentifier($uri, $fragment, $path);

        if (is_object($schema)) {
            $properties = get_object_vars($schema);

            if (!$properties) {
                return [new ProcessedSchema(new ObjectSchemaValidator($uri, $fragment, []), $identifier, [], [])];
            }

            $context = new SchemaContext($this, $identifier, $path);

            foreach (array_intersect_key($this->keywords, $properties) as $keyword) {
                $keyword->process($properties, $context);
            }

            $keywordValidators = $context->getKeywordValidators();

            /** @var scalar|object|list<mixed>|null $value */
            foreach (array_diff_key($properties, $this->keywords) as $name => $value) {
                $keywordValidators[] = new UnknownKeywordValidator($name, $value);
            }

            $processedIdentifier = $context->getIdentifier();

            $processedUri = $processedIdentifier->getUri();
            $processedFragment = $processedIdentifier->getFragment();

            $validator = new ObjectSchemaValidator($processedUri, $processedFragment, $keywordValidators);
            $anchors = $context->getAnchors();
            $references = $context->getReferences();

            $processedSchema = new ProcessedSchema($validator, $processedIdentifier, $anchors, $references);

            $processedSchemas = [$processedSchema, ...$context->getProcessedSchemas()];

            /** @var non-empty-list<ProcessedSchema> $processedSchemas */
            return $processedSchemas;
        }

        if (is_bool($schema)) {
            return [new ProcessedSchema(new BooleanSchemaValidator($uri, $fragment, $schema), $identifier, [], [])];
        }

        throw new SchemaException('The schema must be an object or a boolean.', $path);
    }
}
