<?php

namespace App\Infrastructure\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferConstraintHandler;
use App\Infrastructure\Dto\Interfaces\DataTransferAssertConstraintHandlerInterface;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use App\Rest\Http\Request;
use Codememory\Dto\DataTransferCollection;
use Codememory\Dto\DataTransferControl;
use Codememory\Dto\Interfaces\ConstraintHandlerInterface;
use Codememory\Dto\Interfaces\ConstraintInterface;

final class ValidationByRequestTypeHandler implements ConstraintHandlerInterface
{
    public function __construct(
        private readonly Request $request
    ) {
    }

    /**
     * @param ValidationByRequestType $constraint
     */
    public function handle(ConstraintInterface $constraint, DataTransferControl $dataTransferControl): void
    {
        if ($this->request->getRequestType() === $constraint->type->value) {
            /** @var DataTransferCollection $collection */
            $collection = $dataTransferControl->dataTransfer->getListDataTransferCollection()[$dataTransferControl->dataTransfer::class];

            $collection->addPropertyValidation($dataTransferControl->property->getName(), $constraint->assert);
        }
    }
}