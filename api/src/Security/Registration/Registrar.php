<?php

namespace App\Security\Registration;

use App\Dto\Transfer\RegistrationDto;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\RoleEnum;
use App\Repository\RoleRepository;

final class Registrar
{
    public function __construct(
        private readonly RoleRepository $roleRepository
    ) {
    }

    public function registrar(RegistrationDto $dto, ?User $user): User
    {
        $user = $this->buildUser($dto, $user ?: new User());

        $user->setProfile($this->buildUserProfile($dto, $user->getProfile() ?: new UserProfile()));

        return $user;
    }

    private function buildUser(RegistrationDto $dto, User $user): User
    {
        $user->setEmail($dto->email);
        $user->setPassword($dto->password);
        $user->setRole($this->roleRepository->findByKey(RoleEnum::USER));
        $user->setNotActiveStatus();

        return $user;
    }

    private function buildUserProfile(RegistrationDto $dto, UserProfile $profile): UserProfile
    {
        $profile->setPseudonym($dto->pseudonym);
        $profile->setHideStatus();

        return $profile;
    }
}