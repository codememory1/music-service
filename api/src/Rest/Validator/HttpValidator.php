<?php

namespace App\Rest\Validator;

use App\Enum\ResponseTypeEnum;
use App\Exception\Http\HttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;

class HttpValidator extends AbstractValidator
{
    protected function constraintViolation(?callable $handleConstraintInfo = null): void
    {
        $context = $this;

        parent::constraintViolation($handleConstraintInfo ?: static function(ConstraintViolationInterface $constraintViolation) use ($context): void {
            $context->throwException(new HttpConstraintInfo($constraintViolation));
        });
    }

    private function throwException(HttpConstraintInfo $constraintInfo): void
    {
        if ([] !== $constraintInfo->getPayload()) {
            throw new HttpException($constraintInfo->getStatusCode(), $constraintInfo->getType(), $constraintInfo->getMessage());
        }

        throw new HttpException(422, ResponseTypeEnum::INPUT_VALIDATION, $constraintInfo->getMessage());
    }
}