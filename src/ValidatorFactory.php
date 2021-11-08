<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator;

use Psr\Http\Message\UriInterface;
use Yakimun\JsonSchemaValidator\Exception\JsonLoaderException;
use Yakimun\JsonSchemaValidator\Exception\SchemaException;
use Yakimun\JsonSchemaValidator\Exception\ValidatorFactoryException;
use Yakimun\JsonSchemaValidator\JsonLoader\JsonLoader;
use Yakimun\JsonSchemaValidator\SchemaFinder\SchemaFinder;
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
     * @var list<SchemaFinder>
     * @readonly
     */
    private array $finders;

    /**
     * @param list<SchemaFinder> $finders
     */
    public function __construct(array $finders = [])
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
            foreach ($vocabulary->getKeywords() as $name => $keyword) {
                $keywords[$name] = $keyword;
            }
        }

        $this->processor = new SchemaProcessor($keywords);
        $this->finders = $finders;
    }

    /**
     * @param JsonLoader $loader
     * @param UriInterface $uri
     * @return Validator
     */
    public function createValidator(JsonLoader $loader, UriInterface $uri): Validator
    {
        [$validators, $references] = $this->processSchema($loader, $uri, [], []);

        $processedUris = [(string)$uri];

        while ($unprocessedReferences = array_diff_key($references, $validators, array_flip($processedUris))) {
            $processedUris[] = array_key_first($unprocessedReferences);
            $schemaUri = reset($unprocessedReferences)[0]->withFragment('');

            $loader = $this->findLoader($schemaUri);

            if (!$loader) {
                continue;
            }

            [$validators, $references] = $this->processSchema($loader, $schemaUri, $validators, $references);
        }

        if ($unresolvedReferences = array_diff_key($references, $validators)) {
            $reference = reset($unresolvedReferences);

            $format = 'The "%s" reference must be resolvable. Schema: "%s". Path: "%s".';
            $message = sprintf($format, (string)$reference[0], (string)$reference[1], (string)$reference[2]);
            throw new ValidatorFactoryException($message);
        }

        $schemaValidators = [];
        $dynamicUris = [];

        foreach (array_intersect_key($validators, $references) as $validatorUri => $validator) {
            $schemaValidators[$validatorUri] = $validator[0];

            if ($validator[1]) {
                $dynamicUris[] = $validatorUri;
            }
        }

        return new Validator(reset($validators)[0], $schemaValidators, $dynamicUris);
    }

    /**
     * @param JsonLoader $loader
     * @param UriInterface $uri
     * @param array<string, array{SchemaValidator, bool, UriInterface, JsonPointer}> $validators
     * @param array<string, array{UriInterface, UriInterface, JsonPointer}> $references
     * @return array{
     *     non-empty-array<string, array{SchemaValidator, bool, UriInterface, JsonPointer}>,
     *     array<string, array{UriInterface, UriInterface, JsonPointer}>
     * }
     */
    private function processSchema(JsonLoader $loader, UriInterface $uri, array $validators, array $references): array
    {
        try {
            $schema = $loader->load();
        } catch (JsonLoaderException $e) {
            $message = sprintf('The "%s" schema must be loadable. %s', (string)$uri, $e->getMessage());
            throw new ValidatorFactoryException($message, 0, $e);
        }

        $pointer = new JsonPointer([]);
        $identifier = new SchemaIdentifier($uri, $pointer, $pointer);

        try {
            $processedSchemas = $this->processor->process($schema, $identifier, [], $pointer);
        } catch (SchemaException $e) {
            $message = sprintf('The "%s" schema must be valid. %s', (string)$uri, $e->getMessage());
            throw new ValidatorFactoryException($message, 0, $e);
        }

        foreach ($processedSchemas as $processedSchema) {
            $validator = $processedSchema->getValidator();

            $validators = $this->processIdentifier($validator, $processedSchema->getIdentifier(), $uri, $validators);

            foreach ($processedSchema->getNonCanonicalIdentifiers() as $nonCanonicalIdentifier) {
                $validators = $this->processIdentifier($validator, $nonCanonicalIdentifier, $uri, $validators);
            }

            foreach ($processedSchema->getAnchors() as $anchor) {
                $anchorUriString = (string)$anchor->getUri();
                $anchorPath = $anchor->getPath();

                if (array_key_exists($anchorUriString, $validators)) {
                    $uriString = (string)$uri;
                    $anchorPathString = (string)$anchor->getPath();
                    $existingValidatorPathString = (string)$validators[$anchorUriString][3];

                    $format = 'The "%s" schema must not contain the same anchors. Paths: "%s" and "%s".';
                    $message = sprintf($format, $uriString, $existingValidatorPathString, $anchorPathString);
                    throw new ValidatorFactoryException($message);
                }

                $validators[$anchorUriString] = [$validator, $anchor->isDynamic(), $uri, $anchorPath];
            }

            foreach ($processedSchema->getReferences() as $reference) {
                $referenceUri = $reference->getUri();
                $referenceUriString = (string)$referenceUri;

                if (array_key_exists($referenceUriString, $references)) {
                    continue;
                }

                $references[$referenceUriString] = [$referenceUri, $uri, $reference->getPath()];
            }
        }

        return [$validators, $references];
    }

    /**
     * @param SchemaValidator $validator
     * @param SchemaIdentifier $identifier
     * @param UriInterface $uri
     * @param array<string, array{SchemaValidator, bool, UriInterface, JsonPointer}> $validators
     * @return non-empty-array<string, array{SchemaValidator, bool, UriInterface, JsonPointer}>
     */
    private function processIdentifier(
        SchemaValidator $validator,
        SchemaIdentifier $identifier,
        UriInterface $uri,
        array $validators
    ): array {
        $identifierUriString = (string)$identifier->getUri()->withFragment((string)$identifier->getFragment());
        $identifierPath = $identifier->getPath();

        if (array_key_exists($identifierUriString, $validators)) {
            $uriString = (string)$uri;
            $identifierPathString = (string)$identifierPath;
            $existingValidatorUriString = (string)$validators[$identifierUriString][2];
            $existingValidatorPathString = (string)$validators[$identifierUriString][3];

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

        $validators[$identifierUriString] = [$validator, false, $uri, $identifierPath];

        return $validators;
    }

    /**
     * @param UriInterface $uri
     * @return JsonLoader|null
     */
    private function findLoader(UriInterface $uri): ?JsonLoader
    {
        foreach ($this->finders as $finder) {
            $loader = $finder->find($uri);

            if ($loader !== null) {
                return $loader;
            }
        }

        return null;
    }
}
