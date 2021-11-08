<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\Json\JsonBoolean;
use Yakimun\JsonSchemaValidator\Json\JsonObject;
use Yakimun\JsonSchemaValidator\Json\JsonValue;
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
     * @param JsonValue $schema
     * @param SchemaIdentifier $identifier
     * @param list<SchemaIdentifier> $nonCanonicalIdentifiers
     * @param JsonPointer $path
     * @return non-empty-list<ProcessedSchema>
     */
    public function process(
        JsonValue $schema,
        SchemaIdentifier $identifier,
        array $nonCanonicalIdentifiers,
        JsonPointer $path
    ): array {
        if ($schema instanceof JsonObject) {
            return $this->processObject($schema, $identifier, $nonCanonicalIdentifiers, $path);
        }

        if ($schema instanceof JsonBoolean) {
            return $this->processBoolean($schema, $identifier, $nonCanonicalIdentifiers);
        }

        throw new SchemaException(sprintf('The schema must be an object or a boolean. Path: "%s".', (string)$path));
    }

    /**
     * @param JsonObject $schema
     * @param SchemaIdentifier $identifier
     * @param list<SchemaIdentifier> $nonCanonicalIdentifiers
     * @param JsonPointer $path
     * @return non-empty-list<ProcessedSchema>
     */
    public function processObject(
        JsonObject $schema,
        SchemaIdentifier $identifier,
        array $nonCanonicalIdentifiers,
        JsonPointer $path
    ): array {
        $properties = $schema->getProperties();

        if (!$properties) {
            $validator = new ObjectSchemaValidator($identifier->getUri(), $identifier->getFragment(), []);

            return [new ProcessedSchema($validator, $identifier, $nonCanonicalIdentifiers, [], [])];
        }

        $context = new SchemaContext($this, $properties, $path, $identifier, $nonCanonicalIdentifiers);

        foreach (array_intersect_key($this->keywords, $properties) as $name => $keyword) {
            $keyword->process($properties[$name], $context);
        }

        $keywordValidators = $context->getKeywordValidators();

        foreach (array_diff_key($properties, $this->keywords) as $name => $value) {
            $keywordValidators[] = new UnknownKeywordValidator($name, $value);
        }

        $processedIdentifier = $context->getIdentifier();
        $processedUri = $processedIdentifier->getUri();
        $processedFragment = $processedIdentifier->getFragment();

        $validator = new ObjectSchemaValidator($processedUri, $processedFragment, $keywordValidators);
        $processedNonCanonicalIdentifiers = $context->getNonCanonicalIdentifiers();
        $anchors = $context->getAnchors();
        $references = $context->getReferences();

        $processedSchema = new ProcessedSchema(
            $validator,
            $processedIdentifier,
            $processedNonCanonicalIdentifiers,
            $anchors,
            $references,
        );

        return [$processedSchema, ...$context->getProcessedSchemas()];
    }

    /**
     * @param JsonBoolean $schema
     * @param SchemaIdentifier $identifier
     * @param list<SchemaIdentifier> $nonCanonicalIdentifiers
     * @return non-empty-list<ProcessedSchema>
     */
    private function processBoolean(
        JsonBoolean $schema,
        SchemaIdentifier $identifier,
        array $nonCanonicalIdentifiers
    ): array {
        $uri = $identifier->getUri();
        $fragment = $identifier->getFragment();

        $validator = new BooleanSchemaValidator($uri, $fragment, $schema->getValue());

        return [new ProcessedSchema($validator, $identifier, $nonCanonicalIdentifiers, [], [])];
    }
}
