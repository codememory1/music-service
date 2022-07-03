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

/**
 * Class UserFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
final class UserFactory implements DataFixtureFactoryInterface
{
    private string $pseudonym;
    private string $email;
    private string $password;
    private string $role;
    private ?ReferenceRepository $referenceRepository = null;
    private ?SubscriptionEnum $subscription;

    public function __construct(string $pseudonym, string $email, string $password, RoleEnum $role, ?SubscriptionEnum $subscriptionEnum = null)
    {
        $this->pseudonym = $pseudonym;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role->name;
        $this->subscription = $subscriptionEnum;
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

        $userEntity = new User();
        $userProfileEntity = new UserProfile();

        $userProfileEntity->setPseudonym($this->pseudonym);
        $userProfileEntity->setStatus(UserProfileStatusEnum::HIDE);

        $userEntity->setEmail($this->email);
        $userEntity->setPassword($this->password);
        $userEntity->setRole($role);
        $userEntity->setStatus(UserStatusEnum::ACTIVE);
        $userEntity->setProfile($userProfileEntity);
        $userEntity->setSubscription($subscription);

        return $userEntity;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}