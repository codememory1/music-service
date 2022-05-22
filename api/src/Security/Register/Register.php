<?php

namespace App\Security\Register;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\ResponseTypeEnum;
use App\Enum\UserProfileStatusEnum;
use App\Enum\UserStatusEnum;
use App\Rest\Http\Exceptions\ApiResponseException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Register.
 *
 * @package App\Security\Register
 *
 * @author  Codememory
 */
class Register extends AbstractService
{
    /**
     * @var null|ReRegister
     */
    private ?ReRegister $reRegister = null;

    /**
     * @param ReRegister $reRegister
     *
     * @return void
     */
    public function setReRegister(ReRegister $reRegister): void
    {
        $this->reRegister = $reRegister;
    }

    public function register(RegistrationDTO $registrationDTO): JsonResponse
    {
        if (false === $this->validate($registrationDTO)) {
            return $this->validator->getResponse();
        }

        $finedUser = $this->em->getRepository(User::class)->findOneBy([
            'email' => $registrationDTO->email
        ]);

        if (null !== $finedUser && false === $finedUser->isStatus(UserStatusEnum::NOT_ACTIVE)) {
            throw new ApiResponseException(409, ResponseTypeEnum::EXIST, 'user@existByEmail');
        }

        // Resign if there is a non-activated user
        if (true === $finedUser?->isStatus(UserStatusEnum::NOT_ACTIVE)) {
            $userEntity = $this->collectUserEntity($finedUser, $registrationDTO);

            $this->reRegister->make($registrationDTO, $userEntity);
        } else {
            $userEntity = $this->collectUserEntity(new User(), $registrationDTO);
            $userEntity->setProfile($this->collectUserProfileEntity($registrationDTO));

            $this->em->persist($userEntity);
            $this->em->flush();
        }

        return $this->responseCollection->successRegistration([]);
    }

    /**
     * @param User            $userEntity
     * @param RegistrationDTO $registrationDTO
     *
     * @return User
     */
    private function collectUserEntity(User $userEntity, RegistrationDTO $registrationDTO): User
    {
        $userEntity->setEmail($registrationDTO->email);
        $userEntity->setPassword($registrationDTO->password);

        return $userEntity;
    }

    /**
     * @param RegistrationDTO $registrationDTO
     *
     * @return UserProfile
     */
    private function collectUserProfileEntity(RegistrationDTO $registrationDTO): UserProfile
    {
        $userProfileEntity = new UserProfile();

        $userProfileEntity->setPseudonym($registrationDTO->pseudonym);
        $userProfileEntity->setStatus(UserProfileStatusEnum::HIDE);

        return $userProfileEntity;
    }
}