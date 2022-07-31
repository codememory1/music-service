<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use App\Dto\Interfaces\DataTransferValueInterceptorConstraintHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Exception\LogicException;

/**
 * Class ToEntityCallbackConstraintHandler.
 *
 * @package App\Dto\Constraints
 *
 * @author  Codememory
 */
final class ToEntityCallbackConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferValueInterceptorConstraintHandlerInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
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