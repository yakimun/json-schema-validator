<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

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
     * @param non-empty-list<SchemaIdentifier> $identifiers
     * @param JsonPointer $path
     * @return non-empty-list<ProcessedSchema>
     */
    public function process($schema, array $identifiers, JsonPointer $path): array
    {
        if (is_object($schema)) {
            $properties = get_object_vars($schema);

            if (!$properties) {
                $identifier = end($identifiers);
                $uri = $identifier->getUri();
                $fragment = $identifier->getFragment();

                return [new ProcessedSchema(new ObjectSchemaValidator($uri, $fragment, []), $identifiers, [], [])];
            }

            $context = new SchemaContext($this, $path, $identifiers);

            foreach (array_intersect_key($this->keywords, $properties) as $keyword) {
                $keyword->process($properties, $context);
            }

            $keywordValidators = $context->getKeywordValidators();

            /** @var scalar|object|list<mixed>|null $value */
            foreach (array_diff_key($properties, $this->keywords) as $name => $value) {
                $keywordValidators[] = new UnknownKeywordValidator($name, $value);
            }

            $processedIdentifiers = $context->getIdentifiers();

            $processedIdentifier = end($processedIdentifiers);
            $processedUri = $processedIdentifier->getUri();
            $processedFragment = $processedIdentifier->getFragment();

            $validator = new ObjectSchemaValidator($processedUri, $processedFragment, $keywordValidators);
            $anchors = $context->getAnchors();
            $references = $context->getReferences();

            $processedSchema = new ProcessedSchema($validator, $processedIdentifiers, $anchors, $references);

            return [$processedSchema, ...$context->getProcessedSchemas()];
        }

        if (is_bool($schema)) {
            $identifier = end($identifiers);
            $uri = $identifier->getUri();
            $fragment = $identifier->getFragment();

            return [new ProcessedSchema(new BooleanSchemaValidator($uri, $fragment, $schema), $identifiers, [], [])];
        }

        throw new SchemaException(sprintf('The schema must be an object or a boolean. Path: "%s".', (string)$path));
    }
}
