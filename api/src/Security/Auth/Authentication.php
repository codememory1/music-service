<?php

namespace App\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Service\HashingService;

/**
 * Class Authentication.
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class Authentication extends AbstractSecurity
{
    /**
     * @param User             $identifiedUser
     * @param AuthorizationDTO $authorizationDTO
     *
     * @return Response|User
     */
    public function authenticate(User $identifiedUser, AuthorizationDTO $authorizationDTO): Response|User
    {
        // Check compare password with identified user
        if (!$this->comparePassword($identifiedUser, $authorizationDTO)) {
            return $this->responseCollection->invalid('user@invalidPassword')->getResponse();
        }

        return $identifiedUser;
    }

    /**
     * @param User             $identifiedUser
     * @param AuthorizationDTO $authorizationDTO
     *
     * @return bool
     */
    private function comparePassword(User $identifiedUser, AuthorizationDTO $authorizationDTO): bool
    {
        $passwordHashingService = new HashingService();

        return $passwordHashingService->compare(
            $authorizationDTO->password,
            $identifiedUser->getPassword()
        );
    }
}