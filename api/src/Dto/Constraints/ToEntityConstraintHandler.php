<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use App\Dto\Interfaces\DataTransferValueInterceptorConstraintHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ToEntityConstraintHandler.
 *
 * @package App\Dto\Constraints
 *
 * @author  Codememory
 */
final class ToEntityConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferValueInterceptorConstraintHandlerInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

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