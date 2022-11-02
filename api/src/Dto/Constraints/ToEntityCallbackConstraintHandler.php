<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferValueInterceptorConstraintHandlerInterface;
use App\Infrastucture\Dto\Interfaces\DataTransferConstraintInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Exception\LogicException;

final class ToEntityCallbackConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferValueInterceptorConstraintHandlerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    /**
     * @param ToEntityCallbackConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint, mixed $value): mixed
    {
        if (false === method_exists($this->getDataTransfer(), $constraint->methodName)) {
            throw new LogicException(sprintf('Callback method %s not found in DTO %s', $constraint->methodName, $this->getDataTransfer()::class));
        }

        return $this->getDataTransfer()->{$constraint->methodName}($this->em, $value);
    }
}