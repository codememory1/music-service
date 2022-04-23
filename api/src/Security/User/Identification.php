<?php

namespace App\Security\User;

use App\Entity\User;
use App\Enum\StatusEnum;
use App\Interfaces\UserIdentificationInterface;
use App\Repository\UserRepository;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;

/**
 * Class Identification.
 *
 * @package App\Security\User
 *
 * @author  Codememory
 */
class Identification extends AbstractSecurity
{
    /**
     * @param UserIdentificationInterface $userIdentification
     *
     * @return Response|User
     */
    public function identify(UserIdentificationInterface $userIdentification): Response|User
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);

        // Checking the existence of a user by email or username
        if (null === $finedUser = $userRepository->findByEmail($userIdentification->getLogin())) {
            return $this->responseCollection->notExist('user@failedToIdentityUser')->getResponse();
        }

        // Checking the active account
        if ($finedUser->getStatus() !== StatusEnum::ACTIVE->value) {
            return $this->responseCollection->notActive('user@accountNotActive')->getResponse();
        }

        return $finedUser;
    }
}