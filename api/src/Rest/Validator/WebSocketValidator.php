<?php

namespace App\Rest\Validator;

use App\Exception\WebSocket\WebSocketException;
use Symfony\Component\Validator\ConstraintViolationInterface;

class WebSocketValidator extends AbstractValidator
{
    protected function constraintViolation(?callable $handleConstraintInfo = null): void
    {
        $context = $this;

        parent::constraintViolation($handleConstraintInfo ?: static function(ConstraintViolationInterface $constraintViolation) use ($context): void {
            $context->throwException(new WebSocketConstraintInfo($constraintViolation));
        });
    }

    private function throwException(WebSocketConstraintInfo $constraintInfo): void
    {
        throw new WebSocketException($constraintInfo->getType(), $constraintInfo->getMessage());
    }
}