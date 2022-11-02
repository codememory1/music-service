<?php

namespace App\Dto\Constraints;

use App\Infrastucture\Dto\Interfaces\DataTransferConstraintInterface;
use App\Dto\Interfaces\DataTransferValueInterceptorConstraintHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

final class ToEntityConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferValueInterceptorConstraintHandlerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {}

    /**
     * @param ToEntityConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint, mixed $value): mixed
    {
        $entityRepository = $this->em->getRepository($this->getPropertyTypeName());

        return $entityRepository->findOneBy([
            $constraint->byProperty => $value
        ]);
    }
}