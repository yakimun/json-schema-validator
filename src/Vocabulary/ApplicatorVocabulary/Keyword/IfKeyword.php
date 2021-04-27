<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaValidator\SchemaValidator;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfElseKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfThenElseKeywordHandler;
use Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\KeywordHandler\IfThenKeywordHandler;
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

        $validator = $context->createValidator($property, $context->getIdentifier()->addTokens('if'));

        if ($thenProperty) {
            $thenValidator = $context->createValidator($thenProperty, $context->getIdentifier()->addTokens('then'));
        } else {
            $thenValidator = null;
        }

        if ($elseProperty) {
            $elseValidator = $context->createValidator($elseProperty, $context->getIdentifier()->addTokens('else'));
        } else {
            $elseValidator = null;
        }

        $context->addKeywordHandler($this->createKeywordHandler($validator, $thenValidator, $elseValidator));
    }

    /**
     * @param SchemaValidator $validator
     * @param SchemaValidator|null $thenValidator
     * @param SchemaValidator|null $elseValidator
     * @return IfKeywordHandler|IfThenKeywordHandler|IfElseKeywordHandler|IfThenElseKeywordHandler
     */
    private function createKeywordHandler(
        SchemaValidator $validator,
        ?SchemaValidator $thenValidator,
        ?SchemaValidator $elseValidator
    ): KeywordHandler {
        if ($thenValidator && $elseValidator) {
            return new IfThenElseKeywordHandler($validator, $thenValidator, $elseValidator);
        }

        if ($thenValidator) {
            return new IfThenKeywordHandler($validator, $thenValidator);
        }

        if ($elseValidator) {
            return new IfElseKeywordHandler($validator, $elseValidator);
        }

        return new IfKeywordHandler($validator);
    }
}
