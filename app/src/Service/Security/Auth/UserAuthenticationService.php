<?php

namespace App\Service\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Enum\ApiResponseTypeEnum;
use App\Rest\ApiService;
use App\Rest\Http\Response;
use App\Service\PasswordHashingService;
use Exception;

/**
 * Class UserAuthenticationService.
 *
 * @package App\Service\Security\Auth
 *
 * @author  Codememory
 */
class UserAuthenticationService extends ApiService
{
    /**
     * @param User             $identifiedUser
     * @param AuthorizationDTO $authorizationDTO
     *
     * @throws Exception
     *
     * @return Response|User
     */
    public function authenticate(User $identifiedUser, AuthorizationDTO $authorizationDTO): Response|User
    {
        // Check compare password with identified user
        if (!$this->compare($identifiedUser, $authorizationDTO)) {
            $this->apiResponseSchema->setMessage(
                ApiResponseTypeEnum::CHECK_INCORRECT,
                $this->getTranslation('user@passwordIsIncorrect')
            );

            return new Response($this->apiResponseSchema, 'error', 400);
        }

        return $identifiedUser;
    }

    /**
     * @param User             $identifiedUser
     * @param AuthorizationDTO $authorizationDTO
     *
     * @return bool
     */
    public function compare(User $identifiedUser, AuthorizationDTO $authorizationDTO): bool
    {
        $passwordHashingService = new PasswordHashingService();

        return $passwordHashingService->compare($authorizationDTO->password, $identifiedUser->getPassword());
    }
}