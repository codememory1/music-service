<?php

namespace App\Validator\Constraints;

use App\Interfaces\EntityInterface;
use App\Security\Auth\Authenticator;
use Doctrine\Persistence\ManagerRegistry;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class AuthorizationValidator.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
class AuthorizationValidator extends ConstraintValidator
{
    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;

    /**
     * @var null|Request
     */
    private ?Request $request;

    /**
     * @param ManagerRegistry $managerRegistry
     * @param RequestStack    $requestStack
     */
    public function __construct(ManagerRegistry $managerRegistry, RequestStack $requestStack)
    {
        $this->managerRegistry = $managerRegistry;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @inheritDoc
     *
     * @throws ReflectionException
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        $constraintReflection = new ReflectionClass($value);

        if (!$constraintReflection->implementsInterface(EntityInterface::class)) {
            throw new UnexpectedTypeException($constraint, EntityInterface::class);
        }

        $tokenAuthenticator = new Authenticator($this->request, $this->managerRegistry);

        if (null === $tokenAuthenticator->getUser()) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}