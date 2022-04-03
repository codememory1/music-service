<?php

namespace App\Service\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Enum\ApiResponseTypeEnum;
use App\Repository\UserRepository;
use App\Rest\ApiService;
use App\Rest\Http\Response;
use Doctrine\ORM\NonUniqueResultException;
use Exception;

/**
 * Class UserIdentificationService.
 *
 * @package App\Service\Security\Auth
 *
 * @author  Codememory
 */
class UserIdentificationService extends ApiService
{
    /**
     * @param AuthorizationDTO $authorizationDTO
     *
     * @throws NonUniqueResultException
     * @throws Exception
     *
     * @return Response|User
     */
    public function identify(AuthorizationDTO $authorizationDTO): Response|User
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);

        // Checking the existence of a user by email or username
        if (null === $finedUser = $userRepository->findByLogin($authorizationDTO->login)) {
            $this->apiResponseSchema->setMessage(
                ApiResponseTypeEnum::CHECK_EXIST,
                $this->getTranslation('user@failedToIdentityUser')
            );

            return new Response($this->apiResponseSchema, 'error', 404);
        }

        return $finedUser;
    }
}