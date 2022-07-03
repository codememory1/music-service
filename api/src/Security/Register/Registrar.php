<?php

namespace App\Security\Register;

use App\DTO\RegistrationDTO;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\RoleEnum;
use App\Enum\UserProfileStatusEnum;
use App\Enum\UserStatusEnum;
use App\Service\AbstractService;
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

    public function make(RegistrationDTO $registrationDTO, ?User $userByEmail): User
    {
        if (true === $userByEmail?->isStatus(UserStatusEnum::NOT_ACTIVE)) {
            $userEntity = $this->collectUserEntity($userByEmail, $registrationDTO);

            $this->reRegister->make($registrationDTO, $userEntity);
        } else {
            $userEntity = $this->collectUserEntity(new User(), $registrationDTO);
            $userEntity->setProfile($this->collectUserProfileEntity($registrationDTO));

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
        $userEntity->setStatus(UserStatusEnum::NOT_ACTIVE);

        return $userEntity;
    }

    private function collectUserProfileEntity(RegistrationDTO $registrationDTO): UserProfile
    {
        $userProfileEntity = new UserProfile();

        $userProfileEntity->setPseudonym($registrationDTO->pseudonym);
        $userProfileEntity->setStatus(UserProfileStatusEnum::HIDE);

        return $userProfileEntity;
    }
}