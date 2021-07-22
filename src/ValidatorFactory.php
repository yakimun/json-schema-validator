<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\Exception\SchemaLoaderException;
use Yakimun\JsonSchemaValidator\Exception\ValidatorFactoryException;
use Yakimun\JsonSchemaValidator\SchemaLoader\SchemaLoader;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\ApplicatorVocabulary;
use Yakimun\JsonSchemaValidator\Vocabulary\ContentVocabulary\ContentVocabulary;
use Yakimun\JsonSchemaValidator\Vocabulary\CoreVocabulary\CoreVocabulary;
use Yakimun\JsonSchemaValidator\Vocabulary\FormatAnnotationVocabulary\FormatAnnotationVocabulary;
use Yakimun\JsonSchemaValidator\Vocabulary\MetaDataVocabulary\MetaDataVocabulary;
use Yakimun\JsonSchemaValidator\Vocabulary\UnevaluatedVocabulary\UnevaluatedVocabulary;
use Yakimun\JsonSchemaValidator\Vocabulary\ValidationVocabulary\ValidationVocabulary;

final class ValidatorFactory
{
    /**
     * @var SchemaProcessor
     * @readonly
     */
    private SchemaProcessor $processor;

    /**
     * @var list<SchemaLoader>
     * @readonly
     */
    private array $loaders;

    /**
     * @param list<SchemaLoader> $loaders
     */
    public function __construct(array $loaders = [])
    {
        $vocabularies = [
            new CoreVocabulary(),
            new ApplicatorVocabulary(),
            new UnevaluatedVocabulary(),
            new ValidationVocabulary(),
            new FormatAnnotationVocabulary(),
            new ContentVocabulary(),
            new MetaDataVocabulary(),
        ];

        $keywords = [];

        foreach ($vocabularies as $vocabulary) {
            foreach ($vocabulary->getKeywords() as $keyword) {
                $keywords[$keyword->getName()] = $keyword;
            }
        }

        $this->processor = new SchemaProcessor($keywords);
        $this->loaders = $loaders;
    }

    /**
     * @param mixed $schema
     * @param UriInterface $uri
     * @return Validator
     */
    public function createValidator($schema, UriInterface $uri): Validator
    {
        [$validators, $references] = $this->processSchema($schema, $uri, [], []);

        $processedUris = [(string)$uri];

        while ($unprocessedReferences = array_diff_key($references, $validators, array_flip($processedUris))) {
            $processedUris[] = array_key_first($unprocessedReferences);
            $schemaUri = reset($unprocessedReferences)[0]->withFragment('');

            $result = $this->findLoader($schemaUri);

            if (!$result) {
                continue;
            }

            $schema = $result->getSchema();

            [$validators, $references] = $this->processSchema($schema, $schemaUri, $validators, $references);
        }

        if ($unresolvedReferences = array_diff_key($references, $validators)) {
            $reference = reset($unresolvedReferences);

            $format = 'The "%s" reference must be resolvable. Schema: "%s". Path: "%s".';
            $message = sprintf($format, (string)$reference[0], (string)$reference[1], (string)$reference[2]);
            throw new ValidatorFactoryException($message);
        }

        $schemaValidators = [];

        foreach ($validators as $validatorUri => $validator) {
            $schemaValidators[$validatorUri] = $validator[0];
        }

        return new Validator($schemaValidators);
    }

    /**
     * @param mixed $schema
     * @param UriInterface $uri
     * @param array<string, array{SchemaValidator, UriInterface, JsonPointer}> $validators
     * @param array<string, array{UriInterface, UriInterface, JsonPointer}> $references
     * @return array{
     *     non-empty-array<string, array{SchemaValidator, UriInterface, JsonPointer}>,
     *     array<string, array{UriInterface, UriInterface, JsonPointer}>
     * }
     */
    private function processSchema($schema, UriInterface $uri, array $validators, array $references): array
    {
        $pointer = new JsonPointer();

        try {
            $processedSchemas = $this->processor->process($schema, $uri, $pointer, $pointer);
        } catch (SchemaException $e) {
            $message = sprintf('The "%s" schema must be valid. %s', (string)$uri, $e->getMessage());
            throw new ValidatorFactoryException($message, 0, $e);
        }

        foreach ($processedSchemas as $processedSchema) {
            $validator = $processedSchema->getValidator();
            $identifier = $processedSchema->getIdentifier();
            $identifierUriString = (string)$identifier->getUri()->withFragment((string)$identifier->getFragment());
            $identifierPath = $identifier->getPath();

            if (array_key_exists($identifierUriString, $validators)) {
                $uriString = (string)$uri;
                $identifierPathString = (string)$identifierPath;
                $existingValidatorUriString = (string)$validators[$identifierUriString][1];
                $existingValidatorPathString = (string)$validators[$identifierUriString][2];

                $format = 'The schemas "%s" and "%s" must have different identifiers. Paths: "%s" and "%s".';
                $message = sprintf(
                    $format,
                    $existingValidatorUriString,
                    $uriString,
                    $existingValidatorPathString,
                    $identifierPathString,
                );
                throw new ValidatorFactoryException($message);
            }

            $validators[$identifierUriString] = [$validator, $uri, $identifierPath];

            foreach ($processedSchema->getAnchors() as $anchor) {
                $anchorUriString = (string)$anchor->getUri();
                $anchorPath = $anchor->getPath();

                if (array_key_exists($anchorUriString, $validators)) {
                    $uriString = (string)$uri;
                    $anchorPathString = (string)$anchor->getPath();
                    $existingValidatorPathString = (string)$validators[$anchorUriString][2];

                    $format = 'The "%s" schema must not contain the same anchors. Paths: "%s" and "%s".';
                    $message = sprintf($format, $uriString, $existingValidatorPathString, $anchorPathString);
                    throw new ValidatorFactoryException($message);
                }

                $validators[$anchorUriString] = [$validator, $uri, $anchorPath];
            }

            foreach ($processedSchema->getReferences() as $reference) {
                $referenceUri = $reference->getUri();
                $references[(string)$referenceUri] = [$referenceUri, $uri, $reference->getPath()];
            }
        }

        return [$validators, $references];
    }

    /**
     * @param UriInterface $uri
     * @return SchemaLoaderResult|null
     */
    private function findLoader(UriInterface $uri): ?SchemaLoaderResult
    {
        foreach ($this->loaders as $loader) {
            try {
                $result = $loader->load($uri);
            } catch (SchemaLoaderException $e) {
                $message = sprintf('The "%s" schema must be loadable. %s', (string)$uri, $e->getMessage());
                throw new ValidatorFactoryException($message, 0, $e);
            }

            if ($result !== null) {
                return $result;
            }
        }

        return null;
    }
}
