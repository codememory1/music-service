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
    private string $pseudonym;
    private string $email;
    private ?ReferenceRepository $referenceRepository = null;

    public function __construct(string $pseudonym, SystemUserEnum $email)
    {
        $this->pseudonym = $pseudonym;
        $this->email = $email->value;
    }

    public function factoryMethod(): EntityInterface
    {
        /** @var Role $role */
        $role = $this->referenceRepository->getReference(sprintf('r-%s', RoleEnum::SYSTEM_USER->name));

        $user = new User();
        $userProfile = new UserProfile();

        $userProfile->setPseudonym($this->pseudonym);
        $userProfile->setHideStatus();

        $user->setEmail($this->email);
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