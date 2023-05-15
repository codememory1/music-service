<?php

namespace App\Infrastructure\Dto\Constraints;

use App\Rest\Http\Request;
use Codememory\Dto\DataTransferControl;
use Codememory\Dto\Interfaces\ConstraintHandlerInterface;
use Codememory\Dto\Interfaces\ConstraintInterface;

final class SetterCallByRequestTypeHandler implements ConstraintHandlerInterface
{
    public function __construct(
        private readonly Request $request
    ) {
    }

    /**
     * @param SetterCallByRequestType $constraint
     */
    public function handle(ConstraintInterface $constraint, DataTransferControl $dataTransferControl): void
    {
        if ($this->request->getRequestType() !== $constraint->type->value) {
            if ($constraint->useDefaultValue) {
                $dataTransferControl->setValue($dataTransferControl->property->getDefaultValue());
            } else {
                $dataTransferControl->setIsIgnoreSetterCall(true);
            }
        }
    }
}