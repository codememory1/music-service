<?php

namespace App\Service\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Enum\ApiResponseTypeEnum;
use App\Service\AbstractApiService;
use App\Service\PasswordHashingService;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class UserAuthenticationService
 *
 * @package App\Service\Security\Auth
 *
 * @author  Codememory
 */
class UserAuthenticationService extends AbstractApiService
{

    /**
     * @param User             $identifiedUser
     * @param AuthorizationDTO $authorizationDTO
     *
     * @return ApiResponseService|User
     * @throws Exception
     */
    public function authenticate(User $identifiedUser, AuthorizationDTO $authorizationDTO): ApiResponseService|User
    {

        $passwordHashingService = new PasswordHashingService();

        // Check compare password with identified user
        if (!$passwordHashingService->compare($authorizationDTO->getPassword(), $identifiedUser->getPassword())) {
            $this
                ->prepareApiResponse('error', 400)
                ->setMessage(
                    ApiResponseTypeEnum::IS_INCORRECT,
                    'password_is_incorrect',
                    $this->getTranslation('user@passwordIsIncorrect')
                );

            return $this->getPreparedApiResponse();
        }

        return $identifiedUser;

    }

}