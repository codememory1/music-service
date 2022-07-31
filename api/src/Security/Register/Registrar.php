<?php

namespace App\Security\Register;

use App\Dto\Transfer\RegistrationDto;
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

    public function make(RegistrationDto $registrationDto, ?User $userByEmail): User
    {
        if ($userByEmail?->isNotActive()) {
            $user = $this->collectUserEntity($userByEmail, $registrationDto);

            $this->reRegister->make($registrationDto, $user);
        } else {
            $user = $this->collectUserEntity(new User(), $registrationDto);
            $user->setProfile($this->collectUserProfileEntity($registrationDto));

            $this->addUserDefaultSettingService->add($user);

            $this->flusherService->addPersist($user);
        }

        return $user;
    }

    private function collectUserEntity(User $userEntity, RegistrationDto $registrationDTO): User
    {
        $userEntity->setEmail($registrationDTO->email);
        $userEntity->setPassword($registrationDTO->password);
        $userEntity->setRole($this->em->getRepository(Role::class)->findOneBy([
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