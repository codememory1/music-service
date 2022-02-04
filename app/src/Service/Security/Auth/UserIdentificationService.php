<?php

namespace App\Service\Security\Auth;

use App\Entity\User;
use App\Enums\ApiResponseTypeEnum;
use App\Repository\UserRepository;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;

/**
 * Class UserIdentificationService
 *
 * @package App\Service\Security\Auth
 *
 * @author  Codememory
 */
class UserIdentificationService extends AbstractApiService
{

    /**
     * @param string $emailOrUsername
     *
     * @return ApiResponseService|User
     * @throws Exception
     */
    public function identify(string $emailOrUsername): ApiResponseService|User
    {

        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);

        // Checking the existence of a user by email or username
        if (null === $finedUser = $userRepository->findByLogin($emailOrUsername)) {
            $this->prepareApiResponse('error', 404)
                 ->setMessage(
                     ApiResponseTypeEnum::CHECK_EXIST,
                     'authentication_user',
                     $this->getTranslation('user@failedToIdentityUser')
                 );

            return $this->getPreparedApiResponse();
        }

        return $finedUser;

    }

}