<?php

namespace App\Security;

use App\Entity\RolePermission;
use App\Entity\SubscriptionPermission;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\RoleEnum;
use App\Enum\RolePermissionEnum;
use App\Enum\SubscriptionEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Repository\UserRepository;
use App\Repository\UserSessionRepository;
use App\Security\Http\BearerToken;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AuthorizedUser.
 *
 * @package App\Security
 *
 * @author  Codememory
 */
class AuthorizedUser
{
    private UserRepository $userRepository;
    private UserSessionRepository $userSessionRepository;
    private BearerToken $bearerToken;
    private ?string $accessToken;
    private ?User $user = null;
    private ?UserSession $userSession = null;

    public function __construct(EntityManagerInterface $manager, BearerToken $bearerToken)
    {
        $this->userRepository = $manager->getRepository(User::class);
        $this->userSessionRepository = $manager->getRepository(UserSession::class);
        $this->bearerToken = $bearerToken;

        $this->accessToken = $this->bearerToken->getToken();
    }

    public function setAccessToken(string $token): self
    {
        $this->accessToken = $token;

        $this->bearerToken->setToken($this->accessToken);

        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUserSession(): ?UserSession
    {
        if (null !== $this->userSession) {
            return $this->userSession;
        }

        if (false !== $tokenData = $this->bearerToken->getData()) {
            $finedUser = $this->userRepository->findOneBy(['id' => $tokenData['id']]);
            $this->userSession = $this->userSessionRepository->findOneBy([
                'user' => $finedUser,
                'accessToken' => $this->bearerToken->getToken()
            ]);
        }

        return $this->userSession;
    }

    public function getUser(): ?User
    {
        if (null !== $this->user) {
            return $this->user;
        }

        $this->user = $this->getUserSession()?->getUser();

        return $this->user;
    }

    public function isRole(RoleEnum $roleEnum): bool
    {
        if (null !== $this->getUser()) {
            return $this->getUser()->getRole()->getKey() === $roleEnum->name;
        }

        return false;
    }

    public function isRolePermission(RolePermissionEnum $rolePermissionEnum): bool
    {
        if (null !== $this->getUser()) {
            $rolePermissions = $this->getUser()->getRole()->getPermissions();

            return $rolePermissions->exists(static fn(int $key, RolePermission $rolePermission) => $rolePermission->getPermissionKey()->getKey() === $rolePermissionEnum->name);
        }

        return false;
    }

    public function isSubscription(SubscriptionEnum $subscriptionEnum): bool
    {
        if (null !== $this->getUser()) {
            $subscription = $this->getUser()->getSubscription();

            if (null === $subscription) {
                return false;
            }

            return $subscription->getKey() === $subscriptionEnum->name;
        }

        return false;
    }

    public function isSubscriptionPermission(SubscriptionPermissionEnum $subscriptionPermissionEnum): bool
    {
        if (null !== $this->getUser()) {
            $subscriptionPermissions = $this->getUser()->getSubscription()?->getPermissions();

            if (null === $subscriptionPermissions) {
                return false;
            }

            return $subscriptionPermissions->exists(static fn(int $key, SubscriptionPermission $subscriptionPermission) => $subscriptionPermission->getPermissionKey()->getKey() === $subscriptionPermissionEnum->name);
        }

        return false;
    }
}