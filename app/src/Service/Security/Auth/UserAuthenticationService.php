<?php

namespace App\Service\Security\Auth;

use App\Entity\User;
use App\Enums\ApiResponseTypeEnum;
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
     * @param User   $identifiedUser
     * @param string $password
     *
     * @return ApiResponseService|User
     * @throws Exception
     */
    public function authenticate(User $identifiedUser, string $password): ApiResponseService|User
    {

        $passwordHashingService = new PasswordHashingService();

        // Check compare password with identified user
        if (!$passwordHashingService->compare($password, $identifiedUser->getPassword())) {
            $this->prepareApiResponse('error', 400)
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