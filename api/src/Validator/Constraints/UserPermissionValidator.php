<?php

namespace App\Validator\Constraints;

use App\Entity\RolePermission;
use App\Entity\User;
use App\Enum\RoleEnum;
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
 * Class UserPermissionValidator.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
class UserPermissionValidator extends ConstraintValidator
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
        $manipulatedRecordUser = method_exists($value, 'getUser') ? $value->getUser() : null;

        $authorizedUser = $tokenAuthenticator->getUser();
        $isManipulate = false;

        if (null !== $authorizedUser) {
            $authorizedUserRole = $authorizedUser->getRole();

            // Check that the role is user and the data user is the owner of this entry
            if (RoleEnum::USER === $authorizedUserRole->getKey()
                && null !== $manipulatedRecordUser
                && $manipulatedRecordUser->getId() === $authorizedUser->getId()) {
                $isManipulate = true;
            }

            // We check that the role is not a user and in this role there is a right to this action
            $this->isNotUserRole($authorizedUser, $constraint, $isManipulate);
        }

        if (!$isManipulate) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    /**
     * @param User       $authorizedUser
     * @param Constraint $constraint
     * @param bool       $isManipulate
     *
     * @return void
     */
    private function isNotUserRole(User $authorizedUser, Constraint $constraint, bool &$isManipulate): void
    {
        $authorizedUserRole = $authorizedUser->getRole();
        $authorizedUserPermissions = $authorizedUserRole->getRolePermissions();

        if (RoleEnum::USER !== $authorizedUserRole->getKey()) {
            /** @var RolePermission $authorizedUserPermission */
            foreach ($authorizedUserPermissions as $authorizedUserPermission) {
                $permissionName = $authorizedUserPermission->getRolePermissionName()->getKey();

                if ($permissionName === $constraint->rolePermissionName) {
                    $isManipulate = true;
                }
            }
        }
    }
}