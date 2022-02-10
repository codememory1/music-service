<?php

namespace App\Service\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Enum\ApiResponseTypeEnum;
use App\Repository\UserRepository;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Doctrine\ORM\NonUniqueResultException;
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
     * @param AuthorizationDTO $authorizationDTO
     *
     * @return ApiResponseService|User
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function identify(AuthorizationDTO $authorizationDTO): ApiResponseService|User
    {

        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);

        // Checking the existence of a user by email or username
        if (null === $finedUser = $userRepository->findByLogin($authorizationDTO->getLogin())) {
            $this
                ->prepareApiResponse('error', 404)
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