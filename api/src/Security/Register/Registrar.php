<?php

namespace App\Security\Register;

use App\DTO\RegistrationDTO;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\RoleEnum;
use App\Service\AbstractService;
use App\Service\UserSetting\AddUserDefaultSettingService;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Registrar.
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class Registrar extends AbstractService
{
    #[Required]
    public ?ReRegister $reRegister = null;

    #[Required]
    public ?AddUserDefaultSettingService $addUserDefaultSettingService = null;

    public function make(RegistrationDTO $registrationDTO, ?User $userByEmail): User
    {
        if ($userByEmail?->isNotActive()) {
            $userEntity = $this->collectUserEntity($userByEmail, $registrationDTO);

            $this->reRegister->make($registrationDTO, $userEntity);
        } else {
            $userEntity = $this->collectUserEntity(new User(), $registrationDTO);
            $userEntity->setProfile($this->collectUserProfileEntity($registrationDTO));

            $this->addUserDefaultSettingService->make($userEntity);

            $this->em->persist($userEntity);
        }

        return $userEntity;
    }

    private function collectUserEntity(User $userEntity, RegistrationDTO $registrationDTO): User
    {
        $userEntity->setEmail($registrationDTO->email);
        $userEntity->setPassword($registrationDTO->password);
        $userEntity->setRole($this->em->getRepository(Role::class)->findOneBy([
            'key' => RoleEnum::USER->name
        ]));
        $userEntity->setNotActiveStatus();

        return $userEntity;
    }

    private function collectUserProfileEntity(RegistrationDTO $registrationDTO): UserProfile
    {
        $userProfileEntity = new UserProfile();

        $userProfileEntity->setPseudonym($registrationDTO->pseudonym);
        $userProfileEntity->setHideStatus();

        return $userProfileEntity;
    }
}