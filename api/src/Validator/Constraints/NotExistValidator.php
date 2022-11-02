<?php

namespace App\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class NotExistValidator extends ConstraintValidator
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {}

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof NotExist) {
            throw new UnexpectedTypeException($constraint, NotExist::class);
        }

        if ($constraint->allowedNull && empty($value)) {
            return;
        }

        $classMetaData = $this->em->getClassMetadata($constraint->entity);
        $repository = $this->em->getRepository($constraint->entity);

        if (null !== $repository->findOneBy([$constraint->property => $value])) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ table }}', $classMetaData->getTableName())
                ->setParameter('{{ property }}', $constraint->property)
                ->setParameter('{{ value }}', $value ?? '')
                ->addViolation();
        }
    }
}