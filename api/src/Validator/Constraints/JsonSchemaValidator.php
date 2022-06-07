<?php

namespace App\Validator\Constraints;

use Ergebnis\Json\Pointer\JsonPointer;
use Ergebnis\Json\SchemaValidator\Json;
use Ergebnis\Json\SchemaValidator\SchemaValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class JsonSchemaValidator.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
class JsonSchemaValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof JsonSchema) {
            throw new UnexpectedTypeException($constraint, JsonSchema::class);
        }

        $validationResult = (new SchemaValidator())->validate(
            Json::fromString([] === $value ? '{}' : json_encode($value)),
            $this->readSchema($constraint->schemaName),
            JsonPointer::document()
        );

        if (false === $validationResult->isValid()) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ property }}', $this->context->getPropertyName())
                ->addViolation();
        }
    }

    /**
     * @param string $name
     *
     * @return null|Json
     */
    private function readSchema(string $name): ?Json
    {
        $fullPath = sprintf('%s/../../../config/scheme/%s.json', __DIR__, $name);

        if (file_exists($fullPath)) {
            return Json::fromString(file_get_contents($fullPath));
        }

        return null;
    }
}