<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Role;
use App\Entity\Subscription;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\RoleEnum;
use App\Enum\UserProfileStatusEnum;
use App\Enum\UserStatusEnum;
use function call_user_func;
use Closure;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class UserFactory implements DataFixtureFactoryInterface
{
    private ?ReferenceRepository $referenceRepository = null;

    public function __construct(
        private readonly string $pseudonym,
        private readonly string $email,
        private readonly string $password,
        private readonly RoleEnum $role,
        private readonly ?string $subscriptionTitle = null,
        private readonly ?Closure $callbackEntity = null
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        /** @var Role $role */
        $role = $this->referenceRepository->getReference("r-{$this->role->name}");
        $subscription = null;

        if (null !== $this->subscriptionTitle) {
            /** @var Subscription $subscription */
            $subscription = $this->referenceRepository->getReference("s-{$this->subscriptionTitle}");
        }

        $user = new User();
        $userProfile = new UserProfile();

        $userProfile->setPseudonym($this->pseudonym);
        $userProfile->setStatus(UserProfileStatusEnum::HIDE);

        $user->setEmail($this->email);
        $user->setPassword($this->password);
        $user->setRole($role);
        $user->setStatus(UserStatusEnum::ACTIVE);
        $user->setProfile($userProfile);
        $user->setSubscription($subscription);

        if (null !== $this->callbackEntity) {
            call_user_func($this->callbackEntity, $user);
        }

        return $user;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}