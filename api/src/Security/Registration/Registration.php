<?php

namespace App\Security\Registration;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Enum\StatusEnum;
use App\Repository\UserRepository;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;

/**
 * Class Registration.
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class Registration extends AbstractSecurity
{
    /**
     * @param RegistrationDTO $registrationDTO
     *
     * @return bool|User
     */
    public function isReRegistration(RegistrationDTO $registrationDTO): User|bool
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);

        $finedUser = $userRepository->findOneBy([
            'email' => $registrationDTO->email,
            'status' => StatusEnum::NOT_ACTIVE->value
        ]);

        return null === $finedUser ? false : $finedUser;
    }

    /**
     * @return Response
     */
    public function successRegisterResponse(): Response
    {
        return $this->responseCollection->successRegister()->getResponse();
    }
}