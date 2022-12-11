<?php

namespace App\Security\Register;

use App\Dto\Transfer\RegistrationDto;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\RoleEnum;
use App\Infrastructure\Doctrine\Flusher;
use App\Repository\RoleRepository;
use App\UseCase\User\Setting\AddDefaultUserSetting;

final class Registrar
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly RoleRepository $roleRepository,
        private readonly ReRegister $reRegister,
        private readonly AddDefaultUserSetting $addDefaultUserSetting,
    ) {
    }

    public function make(RegistrationDto $dto, ?User $user): User
    {
        if ($user?->isNotActive()) {
            $user = $this->collectUserEntity($user, $dto);

            $this->reRegister->make($dto, $user);
        } else {
            $user = $this->collectUserEntity(new User(), $dto);
            $user->setProfile($this->collectUserProfileEntity($dto));

            $this->addDefaultUserSetting->process($user);

            $this->flusher->addPersist($user);
        }

        return $user;
    }

    private function collectUserEntity(User $user, RegistrationDto $dto): User
    {
        $user->setEmail($dto->email);
        $user->setPassword($dto->password);
        $user->setRole($this->roleRepository->findByKey(RoleEnum::USER));
        $user->setNotActiveStatus();

        return $user;
    }

    private function collectUserProfileEntity(RegistrationDto $dto): UserProfile
    {
        $userProfile = new UserProfile();

        $userProfile->setPseudonym($dto->pseudonym);
        $userProfile->setHideStatus();

        return $userProfile;
    }
}