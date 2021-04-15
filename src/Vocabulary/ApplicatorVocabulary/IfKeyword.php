<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\Schema\SchemaContext;
use Yakimun\JsonSchemaValidator\Schema\SchemaIdentifier;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\Keyword;
use Yakimun\JsonSchemaValidator\Vocabulary\KeywordHandler;

final class IfKeyword implements Keyword
{
    /**
     * @return string
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return 'if';
    }

    /**
     * @param non-empty-array<string, JsonValue> $properties
     * @param SchemaContext $context
     */
    public function process(array $properties, SchemaContext $context): void
    {
        $property = $properties['if'];

        $thenProperty = $properties['then'] ?? null;
        $elseProperty = $properties['else'] ?? null;

        $identifier = $context->getIdentifier();
        $uri = $identifier->getUri();
        $fragment = $identifier->getFragment();

        $schemaValidator = $context->createValidator($property, new SchemaIdentifier($uri, $fragment->addTokens('if')));

        if ($thenProperty) {
            $thenIdentifier = new SchemaIdentifier($uri, $fragment->addTokens('then'));
            $thenSchemaValidator = $context->createValidator($thenProperty, $thenIdentifier);
        } else {
            $thenSchemaValidator = null;
        }

        if ($elseProperty) {
            $elseIdentifier = new SchemaIdentifier($uri, $fragment->addTokens('else'));
            $elseSchemaValidator = $context->createValidator($elseProperty, $elseIdentifier);
        } else {
            $elseSchemaValidator = null;
        }

        $keywordHandler = $this->createKeywordHandler($schemaValidator, $thenSchemaValidator, $elseSchemaValidator);
        $context->addKeywordHandler($keywordHandler);
    }

    /**
     * @param SchemaValidator $schemaValidator
     * @param SchemaValidator|null $thenSchemaValidator
     * @param SchemaValidator|null $elseSchemaValidator
     * @return IfKeywordHandler|IfThenKeywordHandler|IfElseKeywordHandler|IfThenElseKeywordHandler
     */
    private function createKeywordHandler(
        SchemaValidator $schemaValidator,
        ?SchemaValidator $thenSchemaValidator,
        ?SchemaValidator $elseSchemaValidator
    ): KeywordHandler {
        if ($thenSchemaValidator && $elseSchemaValidator) {
            return new IfThenElseKeywordHandler($schemaValidator, $thenSchemaValidator, $elseSchemaValidator);
        }

        if ($thenSchemaValidator) {
            return new IfThenKeywordHandler($schemaValidator, $thenSchemaValidator);
        }

        if ($elseSchemaValidator) {
            return new IfElseKeywordHandler($schemaValidator, $elseSchemaValidator);
        }

        return new IfKeywordHandler($schemaValidator);
    }
}
