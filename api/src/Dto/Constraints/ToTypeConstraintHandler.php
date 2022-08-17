<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use App\Dto\Interfaces\DataTransferValueInterceptorConstraintHandlerInterface;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use function is_array;
use JetBrains\PhpStorm\Pure;
use const JSON_ERROR_NONE;

final class ToTypeConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferValueInterceptorConstraintHandlerInterface
{
    private ?ToTypeConstraint $constraint = null;

    /**
     * @param ToTypeConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint, mixed $value): mixed
    {
        $this->constraint = $constraint;

        if (true === $this->getPropertyType()->allowsNull() && empty($value)) {
            return null;
        }

        if (true === $this->isType('array')) {
            return $this->toArray($value);
        }

        if (true === $this->isType('string')) {
            return $this->toString($value);
        }

        if (true === $this->isType('int')) {
            return $this->toInteger($value);
        }

        if (true === $this->isType('float')) {
            return $this->toFloat($value);
        }

        if (true === $this->isType('bool')) {
            return $this->toBoolean($value);
        }

        if (true === $this->isType(DateTimeInterface::class)) {
            return $this->toDateTime($value);
        }

        return $value;
    }

    #[Pure]
    private function isType(string $type): bool
    {
        return $type === $this->constraint->type || $type === $this->getPropertyTypeName();
    }

    private function toArray(mixed $value): array
    {
        if (true === is_array($value)) {
            return $value;
        }

        $value = json_decode($value, true);

        if (true === empty($value) || JSON_ERROR_NONE !== json_last_error()) {
            return [];
        }

        return $value;
    }

    private function toString(mixed $value): string
    {
        if (is_array($value)) {
            return json_encode($value);
        }

        return (string) $value;
    }

    private function toInteger(mixed $value): int
    {
        if (is_array($value)) {
            return count($value);
        }

        return (int) $value;
    }

    private function toFloat(mixed $value): float
    {
        return (float) $value;
    }

    private function toBoolean(mixed $value): float
    {
        return 1 === $value || '1' === $value || true === $value || false === empty($value);
    }

    private function toDateTime(mixed $value): ?DateTimeInterface
    {
        try {
            return new DateTimeImmutable($value);
        } catch (Exception) {
            return null;
        }
    }
}