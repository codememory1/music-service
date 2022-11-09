<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\RoleEnum;
use App\Enum\SystemUserEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class SystemUserFactory implements DataFixtureFactoryInterface
{
    private ?ReferenceRepository $referenceRepository = null;

    public function __construct(
        private readonly string $pseudonym,
        private readonly SystemUserEnum $email
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        /** @var Role $role */
        $role = $this->referenceRepository->getReference(sprintf('r-%s', RoleEnum::SYSTEM_USER->name));

        $user = new User();
        $userProfile = new UserProfile();

        $userProfile->setPseudonym($this->pseudonym);
        $userProfile->setHideStatus();

        $user->setEmail($this->email->value);
        $user->setNotActiveStatus();
        $user->setProfile($userProfile);
        $user->setRole($role);

        return $user;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}