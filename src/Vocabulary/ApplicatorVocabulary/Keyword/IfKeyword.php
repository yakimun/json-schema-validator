<?php

declare(strict_types=1);

namespace Yakimun\JsonSchemaValidator\Vocabulary\ApplicatorVocabulary\Keyword;

use Yakimun\JsonSchemaValidator\Json\JsonValue;
use Yakimun\JsonSchemaValidator\SchemaContext;
use Yakimun\JsonSchemaValidator\SchemaIdentifier;
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
        $identifier = $context->getIdentifier()->addTokens('if');
        $validator = $context->createValidator($properties['if'], $identifier);

        $thenProperty = $properties['then'] ?? null;

        if ($thenProperty) {
            $thenIdentifier = $context->getIdentifier()->addTokens('then');
            $thenValidator = $context->createValidator($thenProperty, $thenIdentifier);
        } else {
            $thenIdentifier = null;
            $thenValidator = null;
        }

        $elseProperty = $properties['else'] ?? null;

        if ($elseProperty) {
            $elseIdentifier = $context->getIdentifier()->addTokens('else');
            $elseValidator = $context->createValidator($elseProperty, $elseIdentifier);
        } else {
            $elseIdentifier = null;
            $elseValidator = null;
        }

        $context->addKeywordHandler($this->createKeywordHandler(
            $identifier,
            $validator,
            $thenIdentifier,
            $thenValidator,
            $elseIdentifier,
            $elseValidator,
        ));
    }

    /**
     * @param SchemaIdentifier $identifier
     * @param SchemaValidator $validator
     * @param SchemaIdentifier|null $thenIdentifier
     * @param SchemaValidator|null $thenValidator
     * @param SchemaIdentifier|null $elseIdentifier
     * @param SchemaValidator|null $elseValidator
     * @return IfKeywordHandler|IfThenKeywordHandler|IfElseKeywordHandler|IfThenElseKeywordHandler
     */
    private function createKeywordHandler(
        SchemaIdentifier $identifier,
        SchemaValidator $validator,
        ?SchemaIdentifier $thenIdentifier,
        ?SchemaValidator $thenValidator,
        ?SchemaIdentifier $elseIdentifier,
        ?SchemaValidator $elseValidator
    ): KeywordHandler {
        if ($thenValidator && $elseValidator) {
            return new IfThenElseKeywordHandler(
                (string)$identifier,
                $validator,
                (string)$thenIdentifier,
                $thenValidator,
                (string)$elseIdentifier,
                $elseValidator,
            );
        }

        if ($thenValidator) {
            return new IfThenKeywordHandler((string)$identifier, $validator, (string)$thenIdentifier, $thenValidator);
        }

        if ($elseValidator) {
            return new IfElseKeywordHandler((string)$identifier, $validator, (string)$elseIdentifier, $elseValidator);
        }

        return new IfKeywordHandler((string)$identifier, $validator);
    }
}
