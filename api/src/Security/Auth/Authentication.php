<?php

namespace App\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Enum\ApiResponseTypeEnum;
use App\Rest\Http\ApiResponseSchema;
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
            $apiResponseSchema = new ApiResponseSchema();
            $apiResponseSchema->setMessage(
                ApiResponseTypeEnum::CHECK_INCORRECT,
                $this->translator->getTranslation('user@passwordIsIncorrect')
            );

            return new Response($apiResponseSchema, 'error', 400);
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