<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferCallSetterConstraintHandler;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use App\Rest\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

final class AsPathConstraintHandler extends AbstractDataTransferCallSetterConstraintHandler
{
    public function __construct(
        private readonly Request $request
    ) {
    }

    /**
     * @param AsPathConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint): bool
    {
        if ($this->isPath() && !$this->existInputNameToRequest()) {
            return false;
        }

        $this->getValidationRepository()->addInput($this->getPropertyName(), $this->getPropertyValue());
        $this->getValidationRepository()->addConstraints($this->getPropertyName(), $constraint->assert);

        return true;
    }

    private function isPath(): bool
    {
        return SymfonyRequest::METHOD_PATCH === $this->request->getRequest()->getMethod();
    }

    private function existInputNameToRequest(): bool
    {
        return array_key_exists($this->getPropertyNameAsInputName(), $this->request->all());
    }
}