<?php

namespace App\Security\Auth;

use App\Entity\RolePermission;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\RoleEnum;
use App\Enum\RolePermissionEnum;
use App\Repository\UserRepository;
use App\Repository\UserSessionRepository;
use App\Security\Http\BearerToken;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AuthorizedUser.
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class AuthorizedUser
{
    /**
     * @var BearerToken
     */
    private BearerToken $bearerToken;

    /**
     * @var UserSessionRepository
     */
    private UserSessionRepository $userSessionRepository;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var array|bool
     */
    private array|bool $bearerTokenData;

    /**
     * @var null|User
     */
    private ?User $user;

    /**
     * @param BearerToken            $bearerToken
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(BearerToken $bearerToken, EntityManagerInterface $entityManager)
    {
        $this->bearerToken = $bearerToken;
        $this->userRepository = $entityManager->getRepository(User::class);
        $this->userSessionRepository = $entityManager->getRepository(UserSession::class);
        $this->bearerTokenData = $this->bearerToken->getData();
        $this->user = $this->findUser();
    }

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param RoleEnum $roleEnum
     *
     * @return bool
     */
    public function hasRole(RoleEnum $roleEnum): bool
    {
        if (null !== $this->getUser()) {
            return $this->getUser()->getRole()->getKey() === $roleEnum->name;
        }

        return false;
    }

    /**
     * @param RolePermissionEnum $rolePermissionEnum
     *
     * @return bool
     */
    public function hasRolePermission(RolePermissionEnum $rolePermissionEnum): bool
    {
        if (null !== $this->getUser()) {
            $userRolePermissions = $this->getUser()->getRole()->getPermissions();

            return $userRolePermissions->exists(static fn(int $key, RolePermission $rolePermission) => $rolePermission->getPermissionKey()->getKey() === $rolePermissionEnum->name);
        }

        return false;
    }

    /**
     * @return null|User
     */
    private function findUser(): ?User
    {
        if (false !== $tokenData = $this->bearerTokenData) {
            $finedUser = $this->userRepository->findOneBy(['id' => $tokenData['id']]);
            $finedUserSession = $this->userSessionRepository->findOneBy([
                'user' => $finedUser,
                'accessToken' => $this->bearerToken->getToken()
            ]);

            return null !== $finedUser && null !== $finedUserSession ? $finedUser : null;
        }

        return null;
    }
}