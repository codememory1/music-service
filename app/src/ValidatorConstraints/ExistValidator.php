<?php

namespace App\ValidatorConstraints;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class ExistValidator
 *
 * @package App\ValidatorConstraints
 *
 * @author  Codememory
 */
class ExistValidator extends ConstraintValidator
{

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {

        $this->managerRegistry = $managerRegistry;

    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {

        if (!$constraint instanceof Exist) {
            throw new UnexpectedTypeException($constraint, Exist::class);
        }

        $em = $this->managerRegistry->getManager();
        $classMetaData = $em->getClassMetadata($constraint->entity);
        $repository = $em->getRepository($constraint->entity);

        if (null === $repository->findOneBy([$constraint->property => $value])) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ table }}', $classMetaData->getTableName())
                ->setParameter('{{ property }}', $constraint->property)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

    }

}