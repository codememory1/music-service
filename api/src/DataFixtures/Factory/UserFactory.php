<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Role;
use App\Entity\Subscription;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\RoleEnum;
use App\Enum\SubscriptionEnum;
use App\Enum\UserProfileStatusEnum;
use App\Enum\UserStatusEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class UserFactory implements DataFixtureFactoryInterface
{
    private string $pseudonym;
    private string $email;
    private string $password;
    private string $role;
    private ?ReferenceRepository $referenceRepository = null;
    private ?SubscriptionEnum $subscription;

    public function __construct(string $pseudonym, string $email, string $password, RoleEnum $role, ?SubscriptionEnum $subscription = null)
    {
        $this->pseudonym = $pseudonym;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role->name;
        $this->subscription = $subscription;
    }

    public function factoryMethod(): EntityInterface
    {
        /** @var Role $role */
        $role = $this->referenceRepository->getReference("r-{$this->role}");
        $subscription = null;

        if (null !== $this->subscription) {
            /** @var Subscription $subscription */
            $subscription = $this->referenceRepository->getReference("s-{$this->subscription->name}");
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

        return $user;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}