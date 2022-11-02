<?php

namespace App\Security\Register;

use App\Dto\Transfer\RegistrationDto;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\RoleEnum;
use App\Repository\RoleRepository;
use App\Service\FlusherService;
use App\Service\UserSetting\AddUserDefaultSettingService;

class Registrar
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly RoleRepository $roleRepository,
        private readonly ReRegister $reRegister,
        private readonly AddUserDefaultSettingService $addUserDefaultSetting,
    ) {}

    public function make(RegistrationDto $registrationDto, ?User $userByEmail): User
    {
        if ($userByEmail?->isNotActive()) {
            $user = $this->collectUserEntity($userByEmail, $registrationDto);

            $this->reRegister->make($registrationDto, $user);
        } else {
            $user = $this->collectUserEntity(new User(), $registrationDto);
            $user->setProfile($this->collectUserProfileEntity($registrationDto));

            $this->addUserDefaultSetting->add($user);

            $this->flusherService->addPersist($user);
        }

        return $user;
    }

    private function collectUserEntity(User $userEntity, RegistrationDto $registrationDTO): User
    {
        $userEntity->setEmail($registrationDTO->email);
        $userEntity->setPassword($registrationDTO->password);
        $userEntity->setRole($this->roleRepository->findOneBy([
            'key' => RoleEnum::USER->name
        ]));
        $userEntity->setNotActiveStatus();

        return $userEntity;
    }

    private function collectUserProfileEntity(RegistrationDto $registrationDTO): UserProfile
    {
        $userProfileEntity = new UserProfile();

        $userProfileEntity->setPseudonym($registrationDTO->pseudonym);
        $userProfileEntity->setHideStatus();

        return $userProfileEntity;
    }
}